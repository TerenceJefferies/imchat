$(document).ready(function() {
    
    /**CONFIG VARS**/
    var imchatDisplayClass = 'imchat-msgs';//The class where the messages should be printed
    var imchatGuiClass = 'imchat-gui';//The class where we should retrieve input data
    
    var imchatNameClass = 'imchat-name';//The class where the user inputs their name
    var imchatMsgClass = 'imchat-msg';//The class where the user inputs their message
    var imchatSubmitClass = 'imchat-submit';//The class of the button used to submit a new message
    
    var imchatElementClass = 'imchat-element';//The class of the div that encases a message within the display div
    var imchatElementNameClass = 'imchat-element-name';//The class of the div that encases the senders anme within the element
    var imchatElementTextClass = 'imchat-element-text';//The class of the div that encases the senders message within the element
    
    var imchatPollInterval = 1000;//The time in milliseconds between checking for new messages
    
    var imchatPostRequest = 'ajax/post.php';//The address for the POST requests to be sent
    var imchatPollRequest = 'ajax/poll.php';//The address for the POLL requests to be sent
    /**END CONFIG VARS**/
    
    /*
     * runPoll, runs the AJAX poll to check for new messages
     * 
     * @params
     * - void
     * 
     * @returns
     * - void
     *
     **/
    function runPoll() {
        
        var latest = fetchLatestPostId();
        $.ajax({
            
            type:"POST", 
            url:imchatPollRequest,
            data:"latest=" + latest,
            success:function(data) {
                
                var response = $.parseJSON(data);
                if(!response.errors.length)
                {

                    if(response.msgs.length)
                    {
                        
                        for(var i = 0; i < response.msgs.length; i ++)
                        {

                            $('.' + imchatDisplayClass).prepend('<div data-uid="' + response.msgs[i].id + '" class="' + imchatElementClass + '"><div class="' + imchatElementNameClass + '">' + response.msgs[i].sender + '</div><div class="' + imchatElementTextClass + '">' + response.msgs[i].msg + '</div></div>');
                            
                        }
                        
                    }

                }
                else
                {

                    if(console) console.log("An error occured when processing the poll: " + response.errors);

                }
                setTimeout(runPoll,imchatPollInterval);
                
            },
            error:function() {
                
                if(console) console.log("Unable to run poll, retrying shortly");
                setTimeout(runPoll,imchatPollInterval);
                
            }
            
            
        });
        
    }
    
    /*
     * fetchLatestPostId, retrieves the altest post ID from the messages 
     * displayed
     * 
     * @params
     * - void
     * 
     * @returns
     * - (interger): the latest post ID displayed
     *
     **/
    function fetchLatestPostId()
    {
        
        var id = parseInt($('.' + imchatElementClass).eq(0).attr('data-uid'));
        if(!id) id = 0;
        return id;
        
    }
    
    /*
     * init, performs startup proceedures
     * 
     * @params
     * - void
     * 
     * @returns
     * - void
     *
     **/
    function init() {
        
        runPoll();
        
    }
    
    init();//Run our initialize function
    
    /***Static Listeners***/
    
    $('.' + imchatSubmitClass).click(function() {
       
        $(this).attr('disabled',true);
        $('.' + imchatNameClass).attr('disabled',true);
        $('.' + imchatMsgClass).attr('disabled',true);
        
        var name = $('.' + imchatNameClass).val();
        var msg = $('.' + imchatMsgClass).val();
        
        if(name && msg)
        {
            
            $.ajax({
               
               type:"POST",
               data:"name=" + encodeURIComponent(name) + "&msg=" + encodeURIComponent(msg),
               url:imchatPostRequest,
               success:function(result) {
                   
                   if(!result) alert("No response recieved from server!");
                    var response = $.parseJSON(result);
                    if(!response.errors.length)
                    {

                        alert(response.msg);
                        $('.' + imchatNameClass).removeAttr('disabled');
                        $('.' + imchatMsgClass).removeAttr('disabled');
                        $('.' + imchatSubmitClass).removeAttr('disabled');

                    }
                    else
                    {

                        alert("Oh No! Something went wrong! Error: " + response.errors);
                        $('.' + imchatNameClass).removeAttr('disabled');
                        $('.' + imchatMsgClass).removeAttr('disabled');
                        $('.' + imchatSubmitClass).removeAttr('disabled');

                    }
                       
                   
               },
               error:function() {
                   
                   alert("Oh No! Something went wrong when communicating with the server, please refresh the page and try again");
                   
               }
                
            });
        
        }
        else
        {

            alert("Please enter a name and message before pressing submit");
            $('.' + imchatNameClass).removeAttr('disabled');
            $('.' + imchatMsgClass).removeAttr('disabled');
            $('.' + imchatSubmitClass).removeAttr('disabled');

        }
        
    });
    
});