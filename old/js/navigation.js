var Navigation = (function() {

    function initModals() {

        var overlay = document.querySelector( '.md-overlay' );

        [].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {
            console.log("trigger",i);

            var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                close = modal.querySelector( '.md-close' );

            function removeModal( hasPerspective ) {
                classie.remove( modal, 'md-show' );

                if( hasPerspective ) {
                    classie.remove( document.documentElement, 'md-perspective' );
                }
            }

            function removeModalHandler() {
                removeModal( classie.has( el, 'md-setperspective' ) ); 
            }

            el.addEventListener( 'click', function( ev ) {
                classie.add( modal, 'md-show' );
                overlay.removeEventListener( 'click', removeModalHandler );
                overlay.addEventListener( 'click', removeModalHandler );

                if( classie.has( el, 'md-setperspective' ) ) {
                    setTimeout( function() {
                        classie.add( document.documentElement, 'md-perspective' );
                    }, 25 );
                }
            });

            close.addEventListener( 'click', function( ev ) {
                ev.stopPropagation();
                removeModalHandler();
            });

        } );

    }

    function refreshLinks(cont) {
        cont.find("a.inside-link").click(function(event) {
            event.preventDefault();
            console.log("inside-click");
            var link = $( this ).data('link');
            $.ajax({
                url: link+".html",
                dataType: "html"
                }).done(function(data){
                    $("#main").html(data);
                    refreshLinks($("#main"));
                    initModals();
                    menu.closeMenu();
                    
                    if(history.pushState) {
                        history.pushState(null, null, '#'+link);
                    }
                    else {
                        location.hash = '#'+link;
                    }
                });
        });
    }

     //handle hash changes
    function handleChanges(newHash, oldHash){
        console.log(newHash);

        /*var currentHash = location.hash;*/

        refreshLinks($('body'));
        $.ajax({
            url: (newHash && newHash.length>0)?newHash+".html":"presentation.html",
            dataType: "html"
            }).done(function(data){
                $("#main").html(data);
                refreshLinks($("#main"));
                initModals();
        });
    }

    hasher.changed.add(handleChanges); //add hash change listener
    hasher.initialized.add(handleChanges); //add initialized listener (to grab initial value in case it is already set)
    hasher.init();

    

})();
