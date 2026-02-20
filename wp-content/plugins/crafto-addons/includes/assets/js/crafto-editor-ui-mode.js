! function( $ ) {

    'use strict';

    class e extends elementorModules.ViewModule {
        getDefaultSettings() {
            return {
                editorPreferencesModel: elementor.settings.editorPreferences.model,
                darkModeLinkID: 'crafto-elementor-editor-style-dark-css'
            }
        }
        getDefaultElements() {
            const e = this.getSettings( 'darkModeLinkID' );
            return {
                $darkModeLink: $(`#${e}`)
            }
        }
        bindEvents() {
            this.getSettings('editorPreferencesModel').on( 'change:ui_theme', this.checkStyle, this )
        }
        onInit() {
            super.onInit(), this.$link = this.createLink(), this.checkStyle()
        }
        createLink() {
            return this.elements.$darkModeLink.length ? this.elements.$darkModeLink : $( '<link>', {
                id: this.getSettings( 'darkModeLinkID' ),
                rel: 'stylesheet',
                href: this.elements.$darkModeLink.attr( 'href' )
            })
        }
        checkStyle() {
            const e = this.getSettings( 'editorPreferencesModel' );
            if ( 'light' === e.get( 'ui_theme' )) return void this.$link.remove();
            let t = setTimeout((() => {
                this.$link.attr( 'media', 'auto' === e.get( 'ui_theme' ) ? '(prefers-color-scheme: dark)' : '' ).appendTo(elementorCommon.elements.$body), clearTimeout(t)
            }), 150 )
        }
    }
   
    $( window ).on( 'load', (() => {
        _.defer((() => { new e; }))
    }));

}( jQuery );