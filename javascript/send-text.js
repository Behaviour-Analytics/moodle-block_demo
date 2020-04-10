/**
 * This function is called to initialize the script.
 *
 * @param Object Y Some Moodle thing that gets passed by default.
 * @param array incoming The incoming data from the server.
 */
function initSendText(Y, incoming) {

    var url      = incoming.url;
    var courseId = incoming.courseid;
    var sesskey  = incoming.sesskey;
    var response = incoming.response;

    var textbox = document.getElementById('block_demo_inputtext');

    // Add the event listerner for the button.
    document.getElementById('block_demo_response-form')
        .addEventListener('submit', function() {

            if (textbox.value != '') {
                callServer(url, courseId, textbox.value, sesskey, response);
            } else {
                appendMessage(M.str.block_demo.notext);
            }
        });
}

/**
 * Function called to send data to server.
 *
 * @param string url The name of the file receiving the data
 * @param int courseId The id number of the course
 * @param object outData The data to send to the server
 * @param string sesskey The session key
 * @param string response The teacher response to the question
 */
function callServer(url, courseId, outData, sesskey, response) {

    var req = new XMLHttpRequest();
    req.open('POST', url);
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            appendMessage(response);
            console.log(this.responseText);
        }
    };
    req.send('cid=' + courseId + '&data=' + outData +
             '&sesskey=' + sesskey);
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
