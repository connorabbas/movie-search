<template>
    <div>
        <div class="card shadow-sm" style="">
            <div class="card-body">
                <div v-if="loading">
                    <loader></loader>
                </div>
                <div v-else>
                    <div v-if="noMovie">
                        <p class="mb-0">Search a movie...</p>
                    </div>
                    <div v-if="MovieData == 'No results'">
                        <p class="mb-0">No results</p>
                    </div>
                    <div v-if="showMovie">
                        <div class="row">
                            <div v-if="showPoster" class="col-md-4">
                                <img class="img-fluid shadow" :src="PosterURL + MovieData.poster_path" alt="">
                            </div>
                            <div class="col-md-8">
                                <h3 class="mb-4">{{MovieData.title}}</h3>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="deatils-tab" data-bs-toggle="tab" data-bs-target="#movie_details" type="button" role="tab" aria-controls="movie_details" aria-selected="true">Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation" v-if="showCast">
                                        <button class="nav-link" id="cast-tab" data-bs-toggle="tab" data-bs-target="#cast_details" type="button" role="tab" aria-controls="cast_details" aria-selected="false">Cast</button>
                                    </li>
                                </ul>
                                <div class="tab-content p-3" style="border: 1px solid #dee2e6; border-top:none;">
                                    <div class="tab-pane fade show active" id="movie_details" role="tabpanel" aria-labelledby="deatils-tab">
                                        <p class="small text-muted mb-1">Released: {{MovieData.release_date}}</p>
                                        <p class="small text-muted">Runtime: {{MovieData.runtime}}</p>
                                        <p>{{MovieData.overview}}</p>
                                    </div>
                                    <div class="tab-pane fade" id="cast_details" role="tabpanel" aria-labelledby="cast-tab" v-if="showCast">
                                        <div v-for="(cast_member, index) in MovieData.cast" :key="index">
                                            <p class="mb-0">{{ cast_member.name }}</p>
                                            <p class="small text-muted mb-3">{{ cast_member.character }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from './Loader.vue';
export default {
    components: {
        'loader': Loader,
    },
    props: ['MovieData', 'loading'],
    data() {
        return {
            PosterURL: 'https://image.tmdb.org/t/p/w300',
        }
    },
    computed: {
        noMovie() {
            if (Object.keys(this.MovieData).length === 0) {
                return true;
            } 
            return false;
        },
        showMovie() {
            if (Object.keys(this.MovieData).length && this.MovieData != 'No results') {
                return true;
            } 
            return false;
        },
        showPoster() {
            if (this.MovieData.poster_path != null) {
                return true;
            } 
            return false;
        },
        showCast() {
            if (this.MovieData.cast != null && this.MovieData.cast.length) {
                return true;
            } 
            return false;
        }
    }
}
</script>

<style>
</style>