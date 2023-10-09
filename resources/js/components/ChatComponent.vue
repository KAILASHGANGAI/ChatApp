<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Chat Box</div>
                    <div class="card-body">
                        <div class="list-unstyled" style="height: 300px; overflow-y: scroll;">
                            <div class="p-2" v-for="(message, index) in messages" :key="index">
                                <div class="message message-receive" v-if="message.user.id != user.id">
                                    <p>
                                        <strong>{{ message.user.name }} </strong> {{ message.message }}
                                    </p>
                                </div>
                                <div  class="message message-send" v-else >
                                    <p>
                                        <strong>{{ message.user.name }} </strong> {{ message.message }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input @keyup.enter="sendMessage" type="text" class="form-control" v-model="newMessage"
                        placeholder="Enter your Message...">
                    <span class="text-muited">User is typing....</span>
                </div>
            </div>
            <!-- <div class="col-4">
                <div class="card card-default">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <ul class="list-unstyled" style="height: 300px; overflow-y: scroll;">
                            <li class="p-2">
                                <strong>{{ users.name }}</strong>
                            </li>
                        </ul>
                    </div>

                </div>
            </div> -->
        </div>
    </div>
</template>
<style>
.message p {
 border-radius: 10px;
 padding: 10px 20px 10px 8px;
 margin-top: 5px;
 display: inline-block;
 width: auto;
 margin: 0;   
}
.message-send{
    text-align: right;
    margin-top: 5px;
}
.message-send p{
    background: #e0e3e6;
    color: #2f2d2d;

}
.message-receive p{
    background: #435f7a;
    color: #f5f5f5;
}


</style>
<script>
import axios from 'axios';

export default {
    props: ['user'],
    data() {
        return {
            messages: [],
            newMessage: '',
            users: []
        }
    },
    created() {
        this.fetchmessage();
        Echo.channel('chat')
            .listen('MessageEvent', (e) => {
                this.messages.push(e.message);
            });
    },

    methods: {
        fetchmessage() {
            axios.get('/message').then((res) => {
                this.messages = res.data
            })
        },
        sendMessage() {
            this.messages.push({
                user: this.user,
                message: this.newMessage
            });

            axios.post('/message', { message: this.newMessage }).then((res) => {
                this.newMessage = '';
            })

        }
    }
}
</script>
