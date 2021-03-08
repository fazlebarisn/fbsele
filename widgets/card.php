<?php
namespace Elementor;

class FbseleExampleWidget extends Widget_Base {

    public function get_name() {
        return  'example-table-widget-id';
    }

    public function get_title() {
        return esc_html__( 'Example', 'fbsele' );
    }

    public function get_script_depends() {
        return [
            'fbsele-script'
        ];
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'fbsele-for-elementor' ];
    }

    public function _register_controls() {

        // Header Settings
        $this->start_controls_section(
            'header_section',
            [
                'label' => __( 'Title', 'fbsele' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->style_tab();
    }

    private function style_tab() {}

    protected function render() {

        $settings = $this->get_settings_for_display();
        ?>
            <div class="card">

                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/img_avatar.png'; ?>" alt="Avatar" style="width:100%">

                <div class="container">
                    <h4><b>John Doe</b></h4>
                    <p>Architect & Engineer</p>
                </div>

            </div>

        <?php
    }

    protected function _content_template() {

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new FbseleExampleWidget() );