(function(factory) {
    if (typeof define === "function" && define.amd) {
        // AMD. Register as an anonymous module.
        define([], factory);
    } else if (typeof exports === "object") {
        // Node/CommonJS.
        module.exports = factory();
    } else {
        // Browser globals.
        window.demo = factory();
    }
})(function() {

    // The main program.
    var demo = function(incoming) {

        /**
         * This function adds the event listener for the answer form.
         *
         * @param array incoming Data from server
         */
        function init(data) {

            // Add the event listerner for the answer form.
            document.getElementById('block_demo_response-form')
                .addEventListener('submit', function() {

                    var textbox = document.getElementById('block_demo_inputtext');

                    if (textbox.value != '') {
                        appendMessage(M.str.block_demo.textsent);
                    } else {
                        appendMessage(M.str.block_demo.notext);
                    }
                });
        }

        /**
         * Function called to append a message to the block. The message will be
         * removed after some time.
         *
         * @param string msg The message to append.
         */
        function appendMessage(msg) {

            // Append the message.
            var p = document.getElementById('block_demo_outtext');
            p.innerHTML = msg;

            // Reset the input text box and remove the message.
            setTimeout(function() {
                var tb = document.getElementById('block_demo_inputtext');
                tb.value = '';
                p.innerHTML = '&nbsp';
            }, 2000);
        }

        // End of modular encapsulation, start the program.
        init(incoming);
    }
    return demo;
});
