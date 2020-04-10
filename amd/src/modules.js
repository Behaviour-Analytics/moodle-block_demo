define(['block_demo/demo'],
        function (demo) {

            return {
                init: function() {

                    // Pass the packages to the plugin's client side.
                    window.demo = demo;
                }
            };
        });
