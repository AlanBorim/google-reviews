<?php
if (! defined('ABSPATH')) exit;

class GRE_Google_Reviews_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'google_reviews_slider';
    }

    public function get_title()
    {
        return 'Google Reviews';
    }

    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            ['label' => 'Conteúdo']
        );

        $this->add_control(
            'title',
            [
                'label' => 'Título da seção',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'DEPOIMENTOS',
            ]
        );

        $this->add_control(
            'reviews',
            [
                'label' => 'Depoimentos',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'avatar',
                        'label' => 'Avatar',
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => ['url' => 'https://img.icons8.com/ios-filled/50/user.png'],
                    ],
                    [
                        'name' => 'text',
                        'label' => 'Texto',
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => '"Excelente atendimento, recomendo muito!"',
                    ],
                    [
                        'name' => 'author',
                        'label' => 'Nome',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Carlos A.',
                    ],
                    [
                        'name' => 'role',
                        'label' => 'Cargo ou função',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Cliente',
                    ],
                ],
                'default' => [
                    [
                        'text' => '"Trabalhar contigo fue un verdadero privilegio. Tu compromiso y responsabilidad marcaron la diferencia en nuestra campaña, convirtiendo el desafío del INAC..."',
                        'author' => 'Mariana R.',
                        'role' => 'Coordinadora de Comunicación, Instituto Nacional de Carnes del Uruguay',
                    ],
                    [
                        'text' => '"Trabalhar com a Star, através da Tati, foi uma experiência extremamente positiva. A agência demonstrou profundo conhecimento em mídia capacidade de argumentação estratégica..."',
                        'author' => 'Jasmine / M. Dias Branco',
                        'role' => 'Equipe de Marketing',
                    ],
                    [
                        'text' => '"Tati da Star no Mundo foi uma parceira muito estratégica que atuou conosco na Flash em um momento de estruturação da nossa operação. Com um atendimento sempre próximo e uma visão altamente eficaz de mídia..."',
                        'author' => 'Danilo Lima',
                        'role' => 'Head de Marketing / Flash Benefícios',
                    ],
                    [
                        'text' => '"Excelente atendimento, recomendo muito!"',
                        'author' => 'Carlos A.',
                        'role' => 'Cliente',
                    ],
                    [
                        'text' => '"Profissionais muito competentes e simpáticos."',
                        'author' => 'Beatriz M.',
                        'role' => 'Consumidora',
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_settings',
            ['label' => 'Configurações do Slider']
        );

        $this->add_control(
            'autoplay',
            [
                'label' => 'Autoplay',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Sim',
                'label_off' => 'Não',
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => 'Velocidade do Autoplay (ms)',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_indicators',
            [
                'label' => 'Mostrar Indicadores',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Sim',
                'label_off' => 'Não',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            ['label' => 'Estilo']
        );

        $this->add_control(
            'background_color',
            [
                'label' => 'Cor de Fundo',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b4cb8',
                'selectors' => ['{{WRAPPER}} .gre-blue-frame' => 'background: linear-gradient(135deg, {{VALUE}} 0%, #4a5bc4 100%)']
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => 'Cor do Título',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => ['{{WRAPPER}} .gre-title' => 'color: {{VALUE}}']
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        echo '<div class="gre-container gre-slider-layout">';
        
        // Quadro azul separado
        echo '<div class="gre-blue-frame">';
        echo '<div class="gre-header">';
        echo '<h2 class="gre-title">' . esc_html($settings['title']) . '</h2>';
        echo '<div class="gre-navigation">';
        echo '<button class="gre-nav-btn gre-prev">←</button>';
        echo '<button class="gre-nav-btn gre-next">→</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>'; // .gre-blue-frame
        
        // Container do slider que se estende para fora do quadro azul
        echo '<div class="gre-slider-container">';
        echo '<div class="gre-slider">';
        
        foreach ($settings['reviews'] as $review) {
            echo '<div class="gre-card">';
            echo '<div class="gre-avatar">';
            if (!empty($review['avatar']['url'])) {
                echo '<img src="' . esc_url($review['avatar']['url']) . '" alt="Avatar">';
            } else {
                echo '<svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
                echo '<path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                echo '<circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                echo '</svg>';
            }
            echo '</div>';
            echo '<div class="gre-testimonial-content">';
            echo '<div class="gre-text">' . esc_html($review['text']) . '</div>';
            echo '<a href="#" class="gre-more">Leia mais</a>';
            echo '</div>';
            echo '<div class="gre-author-info">';
            echo '<div class="gre-author">' . esc_html($review['author']) . '</div>';
            echo '<div class="gre-role">' . esc_html($review['role']) . '</div>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>'; // .gre-slider
        echo '</div>'; // .gre-slider-container
        
        // Indicadores (se habilitados)
        if ($settings['show_indicators'] === 'yes') {
            echo '<div class="gre-indicators"></div>';
        }
        
        echo '</div>'; // .gre-container
        
        // Script inline para configurações específicas
        if ($settings['autoplay'] === 'yes') {
            $autoplay_speed = !empty($settings['autoplay_speed']) ? $settings['autoplay_speed'] : 5000;
            echo '<script>';
            echo 'jQuery(document).ready(function($) {';
            echo '  if (typeof startAutoplay === "function") {';
            echo '    startAutoplay(' . $autoplay_speed . ');';
            echo '  }';
            echo '});';
            echo '</script>';
        }
    }
}