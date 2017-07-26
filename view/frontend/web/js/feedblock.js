define(['jquery', 'owlcarouselslider'],
    function(jQuery) {
      return function (config) {
          var owl = jQuery('#itemslider-featured-noticias-' + config.id);
          owl.owlCarousel({
              lazyLoad: true,
              itemsCustom: [ [0, 1], [320, 1], [480, 1], [768, 1], [960, 1], [1280, 1] ],
              responsiveRefreshRate: 50,
              slideSpeed: 200,
              paginationSpeed: 500,
              scrollPerPage: true,
              stopOnHover: true,
              rewindNav: true,
              rewindSpeed: 600,
              pagination: false,
              navigation: true,
              navigationText: false
          }); //end: owl
      }
    });