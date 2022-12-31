<template>
    <div>
        <div class="input-group mb-3" data-bs-theme="dark">
            <input @keyup.enter="searchMovie" data-bs-theme="dark" v-model="SearchBind" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2" />
            <button class="btn btn-primary" type="button" id="button-addon2" @click="searchMovie"><i class="bi bi-search"></i></button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return  {
            SearchBind: '',
            canSearch: true,
        }
    },
    methods: {
        searchMovie() {
            if (this.SearchBind.length) {
                if (this.canSearch) {
                    this.canSearch = false;
                    this.$emit('search-loading', 1);
                    axios.get('/search-movies', {
                        params: {
                            title: this.SearchBind,
                        }
                    })
                    .then(response => {
                        var movieData = {};
                        if (response.data === 'Failed response') {
                            alert('Ivalid Search');
                        } else {
                            movieData = response.data;
                        }
                        console.log(movieData);
                        this.$emit('search-loading', 0);
                        this.$emit('movie-searched', response.data);
                        this.canSearch = true;
                    })
                    .catch(err => {
                        this.$emit('search-loading', 0);
                        if (err.response) {
                            alert("client error: " + err);
                        } else if (err.request) {
                            alert("no response: " + err);
                        } else {
                            alert("something went wrong: " + err);
                        }
                        this.canSearch = true;
                    });
                } else {
                    console.log('waiting for current request...');
                }
            } else {
                alert('Invalid Search');
            }
        }
    },
};
</script>

<style>
</style>