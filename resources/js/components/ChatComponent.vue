<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Chat Box</div>
                    <div class="card-body">
                        <ul class="list-unstyled" style="height: 300px; overflow-y: scroll;">
                            <li class="p-2" v-for="(message, index) in messages" :key="index">
                                <strong>{{message.user.name}} : </strong> {{message.message}}
                            </li>
                            
                        </ul>
                    </div>
                    <input 
                    @keyup.enter="sendMessage"
                    type="text" 
                    class="form-control" 
                    v-model="newMessage" 
                    placeholder="Enter your Message...">
                    <span class="text-muited">User is typing....</span>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-default">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <ul class="list-unstyled" style="height: 300px; overflow-y: scroll;">
                            <li class="p-2">
                                <strong>{{users.name}}</strong>
                            </li>
                        </ul>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
// import Echo from 'laravel-echo';

    export default {
        props:['user'],
    data(){
        return{
            messages:[],
            newMessage:'',
           users:[]
        }
       },
       created(){
        this.fetchmessage();
        Echo.channel('chat')
            .listen('MessageEvent',(e)=>{
                
                this.users = e.message.user
            this.messages.push(e.message);
            })
       },
       
       methods:{
        fetchmessage(){
            axios.get('/message').then((res)=>{
            this.messages = res.data
        })
        },
        sendMessage(){
            this.messages.push({
                user:this.user,
                message : this.newMessage
        });

            axios.post('/message',{message:this.newMessage}).then((res)=>{
                this.newMessage = '';
            })
            
        }
       }
    }
</script>
