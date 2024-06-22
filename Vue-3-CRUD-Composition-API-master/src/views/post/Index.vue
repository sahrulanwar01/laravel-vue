<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>DATA POST</h4>
                        <hr>
                        <router-link :to="{name: 'post.create'}" class="btn btn-md btn-success">TAMBAH POST</router-link>

                        <table class="table table-striped table-bordered mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">NAMA</th>
                                    <th scope="col">MAPEL</th>
                                    <th scope="col">OPTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, postIndex) in posts" :key="postIndex">
                                    <td>{{ post.title }}</td>
                                    <td>
                                        <ul>
                                            <li v-for="(content, contentIndex) in post.contents" :key="contentIndex">
                                                {{ content.content }}
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        <router-link :to="{name: 'post.edit', params:{id: post.id }}" class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        <button @click.prevent="postDelete(post.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';

export default {
    setup() {
        let posts = ref([]);

        // Fetch data from Laravel API
        onMounted(() => {
            axios.get('http://localhost:8000/api/post')
                .then(response => {
                    posts.value = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching posts:', error);
                });
        });

        // Method to delete a post
        function postDelete(id) {
            axios.delete(`http://localhost:8000/api/post/${id}`)
                .then(() => {
                    // Remove the deleted post from the frontend list
                    posts.value = posts.value.filter(post => post.id !== id);
                })
                .catch(error => {
                    console.error('Error deleting post:', error);
                });
        }

        return {
            posts,
            postDelete
        };
    }
};
</script>

<style>
    body {
        background: lightgray;
    }
</style>
