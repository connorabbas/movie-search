<template>
    <div>
        <img v-if="showBackdrop" style="position: absolute; height: 100vh; width: 100%; object-fit: cover;" data-async-image="true" :src="BackdropImage" alt="backdrop" decoding="async" class="">
        <div :class="backdropClass">
            <div class="container" style="z-index: 100;">
                <div style="">
                    <div class="row py-5">
                        <div class="col-md-4 mb-4">
                            <search-area @search-loading="setLoading($event)" @movie-searched="setMovie($event)"></search-area>
                        </div>
                        <div class="col-md-8">
                            <search-landing :MovieData="MovieData" :loading="loading"></search-landing>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SearchArea from './SearchArea.vue';
import SearchLanding from './SearchLanding.vue';

export default {
    components: {
        'search-area': SearchArea,
        'search-landing': SearchLanding,
    },
    data() {
        return {
            MovieData: {},
            loading: 0,
            BackdropImage: '',
            BackDropURL: 'https://image.tmdb.org/t/p/w1280',
        }
    },
    methods: {
        setMovie(data) {
            this.MovieData = data;
            this.setBD();
        },
        setLoading(isLoading) {
            console.log(isLoading);
            this.loading = isLoading;
        },
        setBD() {
            if (this.MovieData.backdrop_path != null) {
                this.BackdropImage = this.BackDropURL + this.MovieData.backdrop_path;
            }
        }
    },
    computed: {
        showBackdrop() {
            if (this.BackdropImage != '') {
                return true;
            }
            return false;
        },
        backdropClass() {
            if (this.BackdropImage != '') {
                return 'movie_backdrop';
            }
        }
    }
};
</script>

<style>
.movie_backdrop {
  z-index: 3;
  position: absolute;
  top: 0px;
  width: 100%;
  height: 100%;
  background-color: rgba(10, 16, 22, 0.5);
  background-image: linear-gradient(185deg, transparent, rgb(10, 16, 22) 95%),
    linear-gradient(transparent, rgb(10, 16, 22) 95%);
}
/* .card {
  background: rgba(255, 255, 255, 0.9) !important;
} */
</style>