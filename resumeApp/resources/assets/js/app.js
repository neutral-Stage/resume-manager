
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('chat-message', require('./components/chatMessage.vue'));
Vue.component('chat-log', require('./components/chatLog.vue'));
Vue.component('chat-composer', require('./components/chatComposer.vue'));

const app = new Vue({
    el: '#VueChat',
    data:{
        messages:[],
        usersInRoom:[],
        currentConvId:'',
        currentUser:''
    },
    methods:{
        addMessage(message){
            // add to the existing messages
            // message.created_at = new Date();
            this.messages.push({
                message:message.message,
                created_at:'just now',
                user:{
                    firstName:''
                },
                client:{
                    firstName:''
                },
                visitor:{
                    firstName:''
                }
            });
            //scroll down :
            if ($("#chatBox").length ){
                $('#chatBox').animate({scrollTop: $('#chatBox')[0].scrollHeight}, 'slow');
            }
            if ($("#chatLogs").length && this.currentUser.admin == 1 ){
                setTimeout(function(){
                    $('html,body').animate({scrollTop: $("#sendMessage").offset().top}, 'slow');
                }, 2000);
            }
            // save to DB and so on.
            axios.post('/messages',message);
        }
    },
    created(){
        var pageUrl = window.location.pathname;
        var partsOfUrl = pageUrl.split('/');
        var conversationID = partsOfUrl[partsOfUrl.length-1];
        if(isNaN(conversationID)){
            conversationID = '';
        }
        axios.get('/messages/'+conversationID).then(response =>{
            this.messages = response.data;
        });

        Echo.channel('talkToSales')
            .listen('MessagePosted',(e) =>{
                // handle event here
                // console.log(e.message);
                // this.messages.push({
                //     message:e.message.message,
                //     created_at:e.message.created_at,
                //     user: e.user
                // });

                var pageUrl = window.location.pathname;
                var partsOfUrl = pageUrl.split('/');
                var conversationID = partsOfUrl[partsOfUrl.length-1];
                if(isNaN(conversationID)){
                    conversationID = '';
                }
                axios.get('/messages/'+conversationID).then(response =>{
                    this.messages = response.data;
                });

                axios.get('/chat/get-conv-id/').then(response =>{
                    this.currentConvId = response.data.conversationId;
                    this.currentUser   = response.data.user;
                });

                // scroll down : only if message is to this conversation.
                if(this.currentConvId === e.message.conversation_id){
                    if ($("#chatBox").length ){
                        setTimeout(function(){
                            $('#chatBox').animate({scrollTop: $('#chatBox')[0].scrollHeight}, 'slow');
                        }, 2000);
                    }
                    if ($("#chatLogs").length ){
                        setTimeout(function(){
                            $('html,body').animate({scrollTop: $("#sendMessage").offset().top}, 'slow');
                        }, 2000);
                    }
                }

                // play sound :
                var chatAudio = document.getElementById("chatAudio");

                // if user is not admin and message is from admin
                if(this.currentUser.admin != 1 && e.message.user_id == 2){
                    chatAudio.play();
                    // open the chat if it is closed.
                    $('#liveChat').click();
                    // write the head is new message
                    $('#chatText').html('New message !');

                    //2 seconds and return it back
                    setTimeout(function () {
                        $('#chatText').html('Chat with us');
                    },4000);
                }

                // if message is to admin !
                if(this.currentUser.admin == 1 && e.message.user_id != 2){
                    chatAudio.play();
                }

            })

    }
});
