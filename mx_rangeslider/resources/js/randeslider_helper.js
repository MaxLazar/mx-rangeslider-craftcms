(function() {
    iSlider = Garnish.Base.extend({
        init: function($el) {
            var t = this;
            this.$el = $($el);
            t.addListener(window, 'resize', function(ev) {
                setTimeout(function() {
                    $($el).ionRangeSlider('update');
                }, 100);
            });
        }
    });

}());