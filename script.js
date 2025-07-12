jQuery(document).ready(function($) {
    // Configuração do slider
    let currentSlide = 0;
    let cardsPerView = 3; // Número de cards visíveis por vez
    let cardWidth = 350; // Largura do card + gap
    let gap = 35;
    let spaceGap = 25; // Espaçamento entre os cards
    
    // Função para calcular cards por view baseado na largura da tela
    function updateCardsPerView() {
        const containerWidth = $('.gre-slider-container').width();
        if (containerWidth < 768) {
            cardsPerView = 1;
            cardWidth = 280 + gap + spaceGap;
        } else if (containerWidth < 1200) {
            cardsPerView = 2;
            cardWidth = 320 + gap + spaceGap;
        } else {
            cardsPerView = 3;
            cardWidth = 350 + gap + spaceGap;
        }
    }
    
    // Função para atualizar a posição do slider
    function updateSliderPosition() {
        const slider = $('.gre-slider');
        const translateX = -(currentSlide * cardWidth);
        slider.css('transform', `translateX(${translateX}px)`);
        
        // Atualizar estado dos botões
        updateNavigationButtons();
        
        // Atualizar indicadores se existirem
        updateIndicators();
    }
    
    // Função para atualizar botões de navegação
    function updateNavigationButtons() {
        const totalCards = $('.gre-card').length;
        const maxSlide = Math.max(0, totalCards - cardsPerView);
        
        $('.gre-prev').prop('disabled', currentSlide <= 0);
        $('.gre-next').prop('disabled', currentSlide >= maxSlide);
    }
    
    // Função para atualizar indicadores
    function updateIndicators() {
        $('.gre-indicator').removeClass('active');
        $('.gre-indicator').eq(currentSlide).addClass('active');
    }
    
    // Função para ir para o próximo slide
    function nextSlide() {
        const totalCards = $('.gre-card').length;
        const maxSlide = Math.max(0, totalCards - cardsPerView);
        
        if (currentSlide < maxSlide) {
            currentSlide++;
            updateSliderPosition();
        }
    }
    
    // Função para ir para o slide anterior
    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSliderPosition();
        }
    }
    
    // Função para ir para um slide específico
    function goToSlide(slideIndex) {
        const totalCards = $('.gre-card').length;
        const maxSlide = Math.max(0, totalCards - cardsPerView);
        
        currentSlide = Math.max(0, Math.min(slideIndex, maxSlide));
        updateSliderPosition();
    }
    
    // NOVA FUNCIONALIDADE: Expandir/Contrair depoimentos
    function toggleTestimonial(card) {
        const textContainer = card.find('.gre-text-container');
        const moreLink = card.find('.gre-more');
        const isExpanded = textContainer.hasClass('expanded');
        
        if (isExpanded) {
            // Contrair
            textContainer.removeClass('expanded');
            card.removeClass('expanded');
            moreLink.text('Leia mais');
        } else {
            // Expandir
            textContainer.addClass('expanded');
            card.addClass('expanded');
            moreLink.text('Fechar');
        }
    }
    
    // Event listener para o link "Leia mais"/"Fechar"
    $(document).on('click', '.gre-more', function(e) {
        e.preventDefault();
        const card = $(this).closest('.gre-card');
        toggleTestimonial(card);
    });
    
    // Event listeners para os botões de navegação
    $(document).on('click', '.gre-next', function(e) {
        e.preventDefault();
        nextSlide();
    });
    
    $(document).on('click', '.gre-prev', function(e) {
        e.preventDefault();
        prevSlide();
    });
    
    // Event listeners para os indicadores
    $(document).on('click', '.gre-indicator', function(e) {
        e.preventDefault();
        const index = $(this).index();
        goToSlide(index);
    });
    
    // Suporte para navegação por teclado
    $(document).on('keydown', function(e) {
        if ($('.gre-container').length > 0) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSlide();
            }
        }
    });
    
    // Suporte para touch/swipe em dispositivos móveis
    let startX = 0;
    let endX = 0;
    
    $(document).on('touchstart', '.gre-slider-container', function(e) {
        startX = e.originalEvent.touches[0].clientX;
    });
    
    $(document).on('touchend', '.gre-slider-container', function(e) {
        endX = e.originalEvent.changedTouches[0].clientX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - próximo slide
                nextSlide();
            } else {
                // Swipe right - slide anterior
                prevSlide();
            }
        }
    }
    
    // Função para inicializar a estrutura dos depoimentos
    function initTestimonialStructure() {
        $('.gre-card').each(function() {
            const card = $(this);
            const textElement = card.find('.gre-text');
            
            // Verificar se já foi inicializado
            if (card.find('.gre-text-container').length === 0) {
                // Envolver o texto em um container com altura fixa
                textElement.wrap('<div class="gre-text-container"></div>');
            }
        });
    }
    
    // Inicialização e responsividade
    function initSlider() {
        updateCardsPerView();
        currentSlide = 0;
        updateSliderPosition();
        
        // Inicializar estrutura dos depoimentos
        initTestimonialStructure();
        
        // Criar indicadores se não existirem
        createIndicators();
    }
    
    // Função para criar indicadores
    function createIndicators() {
        const totalCards = $('.gre-card').length;
        const maxSlides = Math.max(1, totalCards - cardsPerView + 1);
        
        if ($('.gre-indicators').length === 0) {
            const indicatorsHtml = '<div class="gre-indicators"></div>';
            $('.gre-container').append(indicatorsHtml);
        }
        
        const indicatorsContainer = $('.gre-indicators');
        indicatorsContainer.empty();
        
        for (let i = 0; i < maxSlides; i++) {
            const indicator = $(`<div class="gre-indicator ${i === 0 ? 'active' : ''}"></div>`);
            indicatorsContainer.append(indicator);
        }
    }
    
    // Redimensionamento da janela
    $(window).on('resize', function() {
        updateCardsPerView();
        updateSliderPosition();
        createIndicators();
        
        // Reinicializar estrutura se necessário
        initTestimonialStructure();
    });
    
    // Auto-play (opcional - pode ser ativado se necessário)
    let autoplayInterval;
    
    function startAutoplay(interval = 5000) {
        stopAutoplay();
        autoplayInterval = setInterval(function() {
            const totalCards = $('.gre-card').length;
            const maxSlide = Math.max(0, totalCards - cardsPerView);
            
            if (currentSlide >= maxSlide) {
                currentSlide = 0;
            } else {
                currentSlide++;
            }
            updateSliderPosition();
        }, interval);
    }
    
    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }
    
    // Pausar autoplay ao hover (se ativo)
    $(document).on('mouseenter', '.gre-container', stopAutoplay);
    $(document).on('mouseleave', '.gre-container', function() {
        // Descomente a linha abaixo para ativar autoplay
        // startAutoplay();
    });
    
    // Inicializar o slider quando o DOM estiver pronto
    if ($('.gre-container').length > 0) {
        initSlider();
    }
    
    // Reinicializar quando novos elementos forem adicionados (compatibilidade com Elementor)
    $(document).on('DOMNodeInserted', function(e) {
        if ($(e.target).find('.gre-container').length > 0 || $(e.target).hasClass('gre-container')) {
            setTimeout(initSlider, 100);
        }
    });
    
    // Expor função startAutoplay globalmente para compatibilidade
    window.startAutoplay = startAutoplay;
});

