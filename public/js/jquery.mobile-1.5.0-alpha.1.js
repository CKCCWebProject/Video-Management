/*
    I'M SORRY TO JQUERY TEAM FOR DELETING YOUR CODE AND JUST KEEP ONLY FEW CODE
    THAT'S JUST BECAUSE I ONLY WANT TO USE SWIPING FUNCTION BUT THE OTHER FUNCTIONS CONFLICT WITH SOME LIBRARY HERE
*/

/*!
* jQuery Mobile <%= version %>
* Git HEAD hash: f075f58e80e71014bbeb94dc0d2efd4cd800a0ba <> Date: Tue Jan 3 2017 12:51:34 UTC
* http://jquerymobile.com
*
* Copyright 2010, 2017 jQuery Foundation, Inc. and other contributors
* Released under the MIT license.
* http://jquery.org/license
*
*/


//>>label: Touch
//>>group: Events
//>>description: Touch events including: touchstart, touchmove, touchend, tap, taphold, swipe, swipeleft, swiperight

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'events/touch',[
                "jquery",
                "../vmouse",
                "../support/touch" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {

            // var support = {
            //     touch: "ontouchend" in document
            // };
            //
            // $.mobile.support = $.mobile.support || {};
            // $.extend( $.support, support );
            // $.extend( $.mobile.support, support );

        var $document = $( document ),
            // supportTouch = $.mobile.support.touch,
            supportTouch = "ontouchend" in document,
            touchStartEvent = supportTouch ? "touchstart" : "mousedown",
            touchStopEvent = supportTouch ? "touchend" : "mouseup",
            touchMoveEvent = supportTouch ? "touchmove" : "mousemove";

// setup new event shortcuts
        $.each( ( "touchstart touchmove touchend " +
        "tap taphold " +
        "swipe swipeleft swiperight" ).split( " " ), function( i, name ) {

            $.fn[ name ] = function( fn ) {
                return fn ? this.bind( name, fn ) : this.trigger( name );
            };

            // jQuery < 1.8
            if ( $.attrFn ) {
                $.attrFn[ name ] = true;
            }
        } );

        function triggerCustomEvent( obj, eventType, event, bubble ) {
            var originalType = event.type;
            event.type = eventType;
            if ( bubble ) {
                $.event.trigger( event, undefined, obj );
            } else {
                $.event.dispatch.call( obj, event );
            }
            event.type = originalType;
        }

// also handles taphold
        $.event.special.tap = {
            tapholdThreshold: 750,
            emitTapOnTaphold: true,
            setup: function() {
                var thisObject = this,
                    $this = $( thisObject ),
                    isTaphold = false;

                $this.bind( "vmousedown", function( event ) {
                    isTaphold = false;
                    if ( event.which && event.which !== 1 ) {
                        return true;
                    }

                    var origTarget = event.target,
                        timer, clickHandler;

                    function clearTapTimer() {
                        if ( timer ) {
                            $this.bind( "vclick", clickHandler );
                            clearTimeout( timer );
                        }
                    }

                    function clearTapHandlers() {
                        clearTapTimer();

                        $this.unbind( "vclick", clickHandler )
                            .unbind( "vmouseup", clearTapTimer );
                        $document.unbind( "vmousecancel", clearTapHandlers );
                    }

                    clickHandler = function( event ) {
                        clearTapHandlers();

                        // ONLY trigger a 'tap' event if the start target is
                        // the same as the stop target.
                        if ( !isTaphold && origTarget === event.target ) {
                            triggerCustomEvent( thisObject, "tap", event );
                        } else if ( isTaphold ) {
                            event.preventDefault();
                        }
                    };

                    $this.bind( "vmouseup", clearTapTimer );

                    $document.bind( "vmousecancel", clearTapHandlers );

                    timer = setTimeout( function() {
                        if ( !$.event.special.tap.emitTapOnTaphold ) {
                            isTaphold = true;
                        }
                        timer = 0;
                        triggerCustomEvent( thisObject, "taphold", $.Event( "taphold", { target: origTarget } ) );
                    }, $.event.special.tap.tapholdThreshold );
                } );
            },
            teardown: function() {
                $( this ).unbind( "vmousedown" ).unbind( "vclick" ).unbind( "vmouseup" );
                $document.unbind( "vmousecancel" );
            }
        };

// Also handles swipeleft, swiperight
        $.event.special.swipe = {

            // More than this horizontal displacement, and we will suppress scrolling.
            scrollSupressionThreshold: 30,

            // More time than this, and it isn't a swipe.
            durationThreshold: 1000,

            // Swipe horizontal displacement must be more than this.
            horizontalDistanceThreshold: window.devicePixelRatio >= 2 ? 15 : 30,

            // Swipe vertical displacement must be less than this.
            verticalDistanceThreshold: window.devicePixelRatio >= 2 ? 15 : 30,

            getLocation: function( event ) {
                var winPageX = window.pageXOffset,
                    winPageY = window.pageYOffset,
                    x = event.clientX,
                    y = event.clientY;

                if ( event.pageY === 0 && Math.floor( y ) > Math.floor( event.pageY ) ||
                    event.pageX === 0 && Math.floor( x ) > Math.floor( event.pageX ) ) {

                    // iOS4 clientX/clientY have the value that should have been
                    // in pageX/pageY. While pageX/page/ have the value 0
                    x = x - winPageX;
                    y = y - winPageY;
                } else if ( y < ( event.pageY - winPageY ) || x < ( event.pageX - winPageX ) ) {

                    // Some Android browsers have totally bogus values for clientX/Y
                    // when scrolling/zooming a page. Detectable since clientX/clientY
                    // should never be smaller than pageX/pageY minus page scroll
                    x = event.pageX - winPageX;
                    y = event.pageY - winPageY;
                }

                return {
                    x: x,
                    y: y
                };
            },

            start: function( event ) {
                var data = event.originalEvent.touches ?
                        event.originalEvent.touches[ 0 ] : event,
                    location = $.event.special.swipe.getLocation( data );
                return {
                    time: ( new Date() ).getTime(),
                    coords: [ location.x, location.y ],
                    origin: $( event.target )
                };
            },

            stop: function( event ) {
                var data = event.originalEvent.touches ?
                        event.originalEvent.touches[ 0 ] : event,
                    location = $.event.special.swipe.getLocation( data );
                return {
                    time: ( new Date() ).getTime(),
                    coords: [ location.x, location.y ]
                };
            },

            handleSwipe: function( start, stop, thisObject, origTarget ) {
                if ( stop.time - start.time < $.event.special.swipe.durationThreshold &&
                    Math.abs( start.coords[ 0 ] - stop.coords[ 0 ] ) > $.event.special.swipe.horizontalDistanceThreshold &&
                    Math.abs( start.coords[ 1 ] - stop.coords[ 1 ] ) < $.event.special.swipe.verticalDistanceThreshold ) {
                    var direction = start.coords[ 0 ] > stop.coords[ 0 ] ? "swipeleft" : "swiperight";

                    triggerCustomEvent( thisObject, "swipe", $.Event( "swipe", { target: origTarget, swipestart: start, swipestop: stop } ), true );
                    triggerCustomEvent( thisObject, direction, $.Event( direction, { target: origTarget, swipestart: start, swipestop: stop } ), true );
                    return true;
                }
                return false;

            },

            // This serves as a flag to ensure that at most one swipe event event is
            // in work at any given time
            eventInProgress: false,

            setup: function() {
                var events,
                    thisObject = this,
                    $this = $( thisObject ),
                    context = {};

                // Retrieve the events data for this element and add the swipe context
                events = $.data( this, "mobile-events" );
                if ( !events ) {
                    events = { length: 0 };
                    $.data( this, "mobile-events", events );
                }
                events.length++;
                events.swipe = context;

                context.start = function( event ) {

                    // Bail if we're already working on a swipe event
                    if ( $.event.special.swipe.eventInProgress ) {
                        return;
                    }
                    $.event.special.swipe.eventInProgress = true;

                    var stop,
                        start = $.event.special.swipe.start( event ),
                        origTarget = event.target,
                        emitted = false;

                    context.move = function( event ) {
                        if ( !start || event.isDefaultPrevented() ) {
                            return;
                        }

                        stop = $.event.special.swipe.stop( event );
                        if ( !emitted ) {
                            emitted = $.event.special.swipe.handleSwipe( start, stop, thisObject, origTarget );
                            if ( emitted ) {

                                // Reset the context to make way for the next swipe event
                                $.event.special.swipe.eventInProgress = false;
                            }
                        }
                        // prevent scrolling
                        if ( Math.abs( start.coords[ 0 ] - stop.coords[ 0 ] ) > $.event.special.swipe.scrollSupressionThreshold ) {
                            event.preventDefault();
                        }
                    };

                    context.stop = function() {
                        emitted = true;

                        // Reset the context to make way for the next swipe event
                        $.event.special.swipe.eventInProgress = false;
                        $document.off( touchMoveEvent, context.move );
                        context.move = null;
                    };

                    $document.on( touchMoveEvent, context.move )
                        .one( touchStopEvent, context.stop );
                };
                $this.on( touchStartEvent, context.start );
            },

            teardown: function() {
                var events, context;

                events = $.data( this, "mobile-events" );
                if ( events ) {
                    context = events.swipe;
                    delete events.swipe;
                    events.length--;
                    if ( events.length === 0 ) {
                        $.removeData( this, "mobile-events" );
                    }
                }

                if ( context ) {
                    if ( context.start ) {
                        $( this ).off( touchStartEvent, context.start );
                    }
                    if ( context.move ) {
                        $document.off( touchMoveEvent, context.move );
                    }
                    if ( context.stop ) {
                        $document.off( touchStopEvent, context.stop );
                    }
                }
            }
        };
        $.each( {
            taphold: "tap",
            swipeleft: "swipe.left",
            swiperight: "swipe.right"
        }, function( event, sourceEvent ) {

            $.event.special[ event ] = {
                setup: function() {
                    $( this ).bind( sourceEvent, $.noop );
                },
                teardown: function() {
                    $( this ).unbind( sourceEvent );
                }
            };
        } );

        return $.event.special;
    } );


    /*!
     * jQuery Mobile Scroll Events @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Scroll
//>>group: Events
//>>description: Scroll events including: scrollstart, scrollstop

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'events/scroll',[ "jquery" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {

        var scrollEvent = "touchmove scroll";

// setup new event shortcuts
        $.each( [ "scrollstart", "scrollstop" ], function( i, name ) {

            $.fn[ name ] = function( fn ) {
                return fn ? this.bind( name, fn ) : this.trigger( name );
            };

            // jQuery < 1.8
            if ( $.attrFn ) {
                $.attrFn[ name ] = true;
            }
        } );

// also handles scrollstop
        $.event.special.scrollstart = {

            enabled: true,
            setup: function() {

                var thisObject = this,
                    $this = $( thisObject ),
                    scrolling,
                    timer;

                function trigger( event, state ) {
                    var originalEventType = event.type;

                    scrolling = state;

                    event.type = scrolling ? "scrollstart" : "scrollstop";
                    $.event.dispatch.call( thisObject, event );
                    event.type = originalEventType;
                }

                var scrollStartHandler = $.event.special.scrollstart.handler = function ( event ) {

                    if ( !$.event.special.scrollstart.enabled ) {
                        return;
                    }

                    if ( !scrolling ) {
                        trigger( event, true );
                    }

                    clearTimeout( timer );
                    timer = setTimeout( function() {
                        trigger( event, false );
                    }, 50 );
                };

                // iPhone triggers scroll after a small delay; use touchmove instead
                $this.on( scrollEvent, scrollStartHandler );
            },
            teardown: function() {
                $( this ).off( scrollEvent, $.event.special.scrollstart.handler );
            }
        };

        $.each( {
            scrollstop: "scrollstart"
        }, function( event, sourceEvent ) {

            $.event.special[ event ] = {
                setup: function() {
                    $( this ).bind( sourceEvent, $.noop );
                },
                teardown: function() {
                    $( this ).unbind( sourceEvent );
                }
            };
        } );

        return $.event.special;
    } );

    /*!
     * jQuery Mobile Throttled Resize @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Throttled Resize
//>>group: Events
//>>description: Fires a resize event with a slight delay to prevent excessive callback invocation
//>>docs: http://api.jquerymobile.com/throttledresize/

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'events/throttledresize',[ "jquery" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {

        var throttle = 250,
            lastCall = 0,
            heldCall,
            curr,
            diff,
            handler = function() {
                curr = ( new Date() ).getTime();
                diff = curr - lastCall;

                if ( diff >= throttle ) {

                    lastCall = curr;
                    $( this ).trigger( "throttledresize" );

                } else {

                    if ( heldCall ) {
                        clearTimeout( heldCall );
                    }

                    // Promise a held call will still execute
                    heldCall = setTimeout( handler, throttle - diff );
                }
            };

// throttled resize event
        $.event.special.throttledresize = {
            setup: function() {
                $( this ).bind( "resize", handler );
            },
            teardown: function() {
                $( this ).unbind( "resize", handler );
            }
        };

        return $.event.special.throttledresize;
    } );

    /*!
     * jQuery Mobile Orientation Change Event @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Orientation Change
//>>group: Events
//>>description: Provides a wrapper around the inconsistent browser implementations of orientationchange
//>>docs: http://api.jquerymobile.com/orientationchange/

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'events/orientationchange',[
                "jquery",
                "../support/orientation",
                "./throttledresize" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {

        var win = $( window ),
            event_name = "orientationchange",
            get_orientation,
            last_orientation,
            initial_orientation_is_landscape,
            initial_orientation_is_default,
            portrait_map = { "0": true, "180": true },
            ww, wh, landscape_threshold;

// It seems that some device/browser vendors use window.orientation values 0 and 180 to
// denote the "default" orientation. For iOS devices, and most other smart-phones tested,
// the default orientation is always "portrait", but in some Android and RIM based tablets,
// the default orientation is "landscape". The following code attempts to use the window
// dimensions to figure out what the current orientation is, and then makes adjustments
// to the to the portrait_map if necessary, so that we can properly decode the
// window.orientation value whenever get_orientation() is called.
//
// Note that we used to use a media query to figure out what the orientation the browser
// thinks it is in:
//
//     initial_orientation_is_landscape = $.mobile.media("all and (orientation: landscape)");
//
// but there was an iPhone/iPod Touch bug beginning with iOS 4.2, up through iOS 5.1,
// where the browser *ALWAYS* applied the landscape media query. This bug does not
// happen on iPad.

        if ( $.support.orientation ) {

            // Check the window width and height to figure out what the current orientation
            // of the device is at this moment. Note that we've initialized the portrait map
            // values to 0 and 180, *AND* we purposely check for landscape so that if we guess
            // wrong, , we default to the assumption that portrait is the default orientation.
            // We use a threshold check below because on some platforms like iOS, the iPhone
            // form-factor can report a larger width than height if the user turns on the
            // developer console. The actual threshold value is somewhat arbitrary, we just
            // need to make sure it is large enough to exclude the developer console case.

            ww = window.innerWidth || win.width();
            wh = window.innerHeight || win.height();
            landscape_threshold = 50;

            initial_orientation_is_landscape = ww > wh && ( ww - wh ) > landscape_threshold;

            // Now check to see if the current window.orientation is 0 or 180.
            initial_orientation_is_default = portrait_map[ window.orientation ];

            // If the initial orientation is landscape, but window.orientation reports 0 or 180, *OR*
            // if the initial orientation is portrait, but window.orientation reports 90 or -90, we
            // need to flip our portrait_map values because landscape is the default orientation for
            // this device/browser.
            if ( ( initial_orientation_is_landscape && initial_orientation_is_default ) || ( !initial_orientation_is_landscape && !initial_orientation_is_default ) ) {
                portrait_map = { "-90": true, "90": true };
            }
        }

// If the event is not supported natively, this handler will be bound to
// the window resize event to simulate the orientationchange event.
        function handler() {
            // Get the current orientation.
            var orientation = get_orientation();

            if ( orientation !== last_orientation ) {
                // The orientation has changed, so trigger the orientationchange event.
                last_orientation = orientation;
                win.trigger( event_name );
            }
        }

        $.event.special.orientationchange = $.extend( {}, $.event.special.orientationchange, {
            setup: function() {
                // If the event is supported natively, return false so that jQuery
                // will bind to the event using DOM methods.
                if ( $.support.orientation && !$.event.special.orientationchange.disabled ) {
                    return false;
                }

                // Get the current orientation to avoid initial double-triggering.
                last_orientation = get_orientation();

                // Because the orientationchange event doesn't exist, simulate the
                // event by testing window dimensions on resize.
                win.bind( "throttledresize", handler );
            },
            teardown: function() {
                // If the event is not supported natively, return false so that
                // jQuery will unbind the event using DOM methods.
                if ( $.support.orientation && !$.event.special.orientationchange.disabled ) {
                    return false;
                }

                // Because the orientationchange event doesn't exist, unbind the
                // resize event handler.
                win.unbind( "throttledresize", handler );
            },
            add: function( handleObj ) {
                // Save a reference to the bound event handler.
                var old_handler = handleObj.handler;

                handleObj.handler = function( event ) {
                    // Modify event object, adding the .orientation property.
                    event.orientation = get_orientation();

                    // Call the originally-bound event handler and return its result.
                    return old_handler.apply( this, arguments );
                };
            }
        } );

// Get the current page orientation. This method is exposed publicly, should it
// be needed, as jQuery.event.special.orientationchange.orientation()
        $.event.special.orientationchange.orientation = get_orientation = function() {
            var isPortrait = true,
                elem = document.documentElement;

            // prefer window orientation to the calculation based on screensize as
            // the actual screen resize takes place before or after the orientation change event
            // has been fired depending on implementation (eg android 2.3 is before, iphone after).
            // More testing is required to determine if a more reliable method of determining the new screensize
            // is possible when orientationchange is fired. (eg, use media queries + element + opacity)
            if ( $.support.orientation ) {
                // if the window orientation registers as 0 or 180 degrees report
                // portrait, otherwise landscape
                isPortrait = portrait_map[ window.orientation ];
            } else {
                isPortrait = elem && elem.clientWidth / elem.clientHeight < 1.1;
            }

            return isPortrait ? "portrait" : "landscape";
        };

        $.fn[ event_name ] = function( fn ) {
            return fn ? this.bind( event_name, fn ) : this.trigger( event_name );
        };

// jQuery < 1.8
        if ( $.attrFn ) {
            $.attrFn[ event_name ] = true;
        }

        return $.event.special;
    } );

    /*!
     * jQuery Mobile Events @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Events
//>>group: Events
//>>description: Custom events and shortcuts.

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'events',[
                "jquery",
                "./events/navigate",
                "./events/touch",
                "./events/scroll",
                "./events/orientationchange" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function() {} );

    /*!
     * jQuery Mobile Path Utility @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Path Helpers
//>>group: Navigation
//>>description: Path parsing and manipulation helpers
//>>docs: http://api.jquerymobile.com/category/methods/path/

    /*!
     * jQuery Mobile History Manager @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Enhancer
//>>group: Widgets
//>>description: Enhables declarative initalization of widgets
//>>docs: http://api.jquerymobile.com/enhancer/

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'widgets/enhancer',[
                "jquery" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {

        var widgetBaseClass,
            installed = false;

        $.fn.extend( {
            enhance: function() {
                return $.enhance.enhance( this );
            },
            enhanceWithin: function() {
                this.children().enhance();
                return this;
            },
            enhanceOptions: function() {
                return $.enhance.getOptions( this );
            },
            enhanceRoles: function() {
                return $.enhance.getRoles( this );
            }
        } );
        $.enhance = $.enhance || {};
        $.extend( $.enhance, {

            enhance: function( elem ) {
                var i,
                    enhanceables = elem.find( "[" + $.enhance.defaultProp() + "]" ).addBack();

                if ( $.enhance._filter ) {
                    enhanceables = $.enhance._filter( enhanceables );
                }

                // Loop over and execute any hooks that exist
                for ( i = 0; i < $.enhance.hooks.length; i++ ) {
                    $.enhance.hooks[ i ].call( elem, enhanceables );
                }

                // Call the default enhancer function
                $.enhance.defaultFunction.call( elem, enhanceables );

                return elem;
            },

            // Check if the enhancer has already been defined if it has copy its hooks if not
            // define an empty array
            hooks: $.enhance.hooks || [],

            _filter: $.enhance._filter || false,

            defaultProp: $.enhance.defaultProp || function() { return "data-ui-role"; },

            defaultFunction: function( enhanceables ) {
                enhanceables.each( function() {
                    var i,
                        roles = $( this ).enhanceRoles();

                    for ( i = 0; i < roles.length; i++ ) {
                        if ( $.fn[ roles[ i ] ] ) {
                            $( this )[ roles[ i ] ]();
                        }
                    }
                } );
            },

            cache: true,

            roleCache: {},

            getRoles: function( element ) {
                if ( !element.length ) {
                    return [];
                }

                var role,

                    // Look for cached roles
                    roles = $.enhance.roleCache[ !!element[ 0 ].id ? element[ 0 ].id : undefined ];

                // We already have done this return the roles
                if ( roles ) {
                    return roles;
                }

                // This is our first time get the attribute and parse it
                role = element.attr( $.enhance.defaultProp() );
                roles = role ? role.match( /\S+/g ) : [];

                // Caches the array of roles for next time
                $.enhance.roleCache[ element[ 0 ].id ] = roles;

                // Return the roles
                return roles;
            },

            optionCache: {},

            getOptions: function( element ) {
                var options = $.enhance.optionCache[ !!element[ 0 ].id ? element[ 0 ].id : undefined ],
                    ns;

                // Been there done that return what we already found
                if ( !!options ) {
                    return options;
                }

                // This is the first time lets compile the options object
                options = {};
                ns = ( $.mobile.ns || "ui-" ).replace( "-", "" );

                $.each( $( element ).data(), function( option, value ) {
                    option = option.replace( ns, "" );

                    option = option.charAt( 0 ).toLowerCase() + option.slice( 1 );
                    options[ option ] = value;
                } );

                // Cache the options for next time
                $.enhance.optionCache[ element[ 0 ].id ] = options;

                // Return the options
                return options;
            },

            _installWidget: function() {
                if ( $.Widget && !installed ) {
                    $.extend( $.Widget.prototype, {
                        _getCreateOptions: function( options ) {
                            var option, value,
                                dataOptions = this.element.enhanceOptions();

                            options = options || {};

                            // Translate data-attributes to options
                            for ( option in this.options ) {
                                value = dataOptions[ option ];
                                if ( value !== undefined ) {
                                    options[ option ] = value;
                                }
                            }
                            return options;
                        }
                    } );
                    installed = true;
                }
            }
        } );

        if ( !$.Widget ) {
            Object.defineProperty( $, "Widget", {
                configurable: true,
                enumerable: true,
                get: function() {
                    return widgetBaseClass;
                },
                set: function( newValue ) {
                    if ( newValue ) {
                        widgetBaseClass = newValue;
                        setTimeout( function() {
                            $.enhance._installWidget();
                        } );
                    }
                }
            } );
        } else {
            $.enhance._installWidget();
        }

        return $.enhance;
    } );

    /*!
     * jQuery Mobile Enhancer @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Enhancer Widget Crawler
//>>group: Widgets
//>>description: Adds support for custom initSlectors on widget prototypes
//>>docs: http://api.jquerymobile.com/enhancer/

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'widgets/enhancer.widgetCrawler',[
                "jquery",
                "../core",
                "widgets/enhancer" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {

        var widgetCrawler = function( elements, _childConstructors ) {
                $.each( _childConstructors, function( index, constructor ) {
                    var prototype = constructor.prototype,
                        plugin = $.enhance,
                        selector = plugin.initGenerator( prototype ),
                        found;

                    if( !selector ) {
                        return;
                    }

                    found = elements.find( selector );

                    if ( plugin._filter ) {
                        found = plugin._filter( found );
                    }

                    found[ prototype.widgetName ]();
                    if ( constructor._childConstructors && constructor._childConstructors.length > 0 ) {
                        widgetCrawler( elements, constructor._childConstructors );
                    }
                } );
            },
            widgetHook = function() {
                if ( !$.enhance.initGenerator || !$.Widget ) {
                    return;
                }

                // Enhance widgets with custom initSelectors
                widgetCrawler( this.addBack(), $.Widget._childConstructors );
            };

        $.enhance.hooks.push( widgetHook );

        return $.enhance;

    } );

    /*!
     * jQuery Mobile Enhancer Backcompat@VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

//>>label: Enhancer
//>>group: Widgets
//>>description: Enables declarative initalization of widgets
//>>docs: http://api.jquerymobile.com/enhancer/

    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( 'widgets/enhancer.backcompat',[
                "jquery",
                "widgets/enhancer",
                "widgets/enhancer.widgetCrawler" ], factory );
        } else {

            // Browser globals
            factory( jQuery );
        }
    } )( function( $ ) {
        if ( $.mobileBackcompat !== false ) {
            var filter = function( elements ) {
                    elements = elements.not( $.mobile.keepNative );

                    if ( $.mobile.ignoreContentEnabled ) {
                        elements.each( function() {
                            if ( $( this )
                                    .closest( "[data-" + $.mobile.ns + "enhance='false']" ).length ) {
                                elements = elements.not( this );
                            }
                        } );
                    }
                    return elements;
                },
                generator = function( prototype ) {
                    return prototype.initSelector ||
                        $[ prototype.namespace ][ prototype.widgetName ].prototype.initSelector || false;
                };

            $.enhance._filter = filter;
            $.enhance.defaultProp = function() {
                return "data-" + $.mobile.ns + "role";
            };
            $.enhance.initGenerator = generator;

        }

        return $.enhance;

    } );

    /*!
     * jQuery Mobile Page @VERSION
     * http://jquerymobile.com
     *
     * Copyright jQuery Foundation and other contributors
     * Released under the MIT license.
     * http://jquery.org/license
     */

