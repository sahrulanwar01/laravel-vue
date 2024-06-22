<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>TAMBAH POST</h4>
                        <hr>

                        <form @submit.prevent="store">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control" v-model="post.title" placeholder="Masukkan Judul Post">
                                <!-- Validation -->
                                <div v-if="validation.title" class="mt-2 alert alert-danger">
                                    {{ validation.title[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="font-weight-bold">CONTENT</label>
                                <textarea class="form-control" rows="4" v-model="content" placeholder="Masukkan Konten Post"></textarea>
                                <!-- Validation -->
                                <div v-if="validation.content" class="mt-2 alert alert-danger">
                                    {{ validation.content[0] }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </form>                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default {
    setup() {
        const post = reactive({
            title: '',
        })

        const content = ref('')
        const validation = ref({
            title: null,
            content: null
        })
        const router = useRouter()

        function store() {
            const { title } = post
            const contentValue = content.value

            axios.post('http://localhost:8000/api/post', {
                title,
                content: contentValue
            })
            .then(() => {
                router.push({ name: 'post.index' })
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    validation.value.title = error.response.data.title ? error.response.data.title[0] : null
                    validation.value.content = error.response.data.content ? error.response.data.content[0] : null
                }
            })
        }

        return {
            post,
            content,
            validation,
            store
        }
    }
}
</script>

<style>
    body {
        background: lightgray;
    }
</style>
