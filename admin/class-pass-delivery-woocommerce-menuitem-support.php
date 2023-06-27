<?php
if (!class_exists('Pass_Delivery_Woocommerce_Menuitem_Support')) {
    class Pass_Delivery_Woocommerce_Menuitem_Support
    {
        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;

            $this->add_support_to_admin_menu_item();
        }

        private function add_support_to_admin_menu_item()
        {
            add_submenu_page(Pass_Delivery_Woocommerce_Admin_Panel::$parent_slug, __('Support', PASS_TRANSLATE_ID), __('Support', PASS_TRANSLATE_ID), 'manage_options', 'pass-support', function () {
                /*echo get_local_template_part('pass-woocommerce-shipping-admin-support-page', array(
                    'log_url' => $this->helpers->get_log_url(),
                    'chat_url' => $this->helpers->get_chat_url(),
                    'dev_email' => $this->helpers->get_config('devEmail'),
                    'support_tel' => $this->helpers->get_support_tel(),
                ));*/
                echo $this->load_support_template();
            });
        }

        private function load_support_template()
        {
            $font = plugins_url('pass-delivery-woocommerce/admin/assets/font/Nunito-Regular.ttf');
            $logo = plugins_url('pass-delivery-woocommerce/admin/assets/img/logo.png');
            return "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'
                        integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC'
                        crossorigin='anonymous'>
                    <style>
                      /* ----------------- font ------------------------- */
                      @font-face {
                        font-family: Nunito;
                        font-weight: normal;
                            src: url('{$font}');
                      }
                      /* ----------------- ./font ------------------------- */
                      .row--style {
                        background-color: #f0f0f0;
                      }
                      .card--style {
                        background-color: white !important;
                        border-radius: 26px !important;
                        box-shadow: 0px 11px 43px #00000029;
                      }
                      .card--text__style {
                        font-family: Nunito, sans-serif;
                        font-size: 16px;
                        color: #00204a;
                      }
                      .btn--style,
                      .btn--style:hover {
                        text-decoration: none !important;
                        cursor: pointer;
                        color: white;
                        font-family: Nunito, sans-serif;
                        font-size: 16px;
                        background-color: #00b7c2;
                        border-radius: 29px;
                        padding: 10px 30px;
                      }
                    </style>
                    <section class='main'>
                      <div class='container-fluid'>
                        <div class='row min-vh-100 align-items-center row--style'>
                          <div class='col-md-7 col-lg-5 p-5 d-table mx-auto'>
                            <div class='card card--style'>
                              <img
                                class='d-table mx-auto mt-5'
                                width='110px'
                                src='{$logo}'
                                alt='pass logo'
                              />
                              <div class='card-body'>
                                <p class='card-text text-center my-5 card--text__style'>
                                  Lorem Ipsum is simply dummy text of the printing and
                                  typesetting industry. Lorem Ipsum has been the industry's
                                  standard dummy text ever since the 1500s, when an uLorem Ipsum
                                  is simply dummy text of the printing and typesetting industry.
                                  Lorem Ipsum has been the industry's standard dummy text ever
                                  since the 1500s, when an u
                                </p>
                                <div class='col-12 d-flex justify-content-center'>
                                  <a href='https://dashboard.pass.qa/' class='btn--style' target='_blank'>Go to my Dashboard panel</a>
                                </div>
                                <div class='col-12 my-3 d-flex justify-content-center'>
                                  <a href='mailto:support@pass.qa' class='btn--style'>support@pass.qa</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <script
                     src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM'
                     crossorigin='anonymous'>
                    </script>";
        }
    }
}