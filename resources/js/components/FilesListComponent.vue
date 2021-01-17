<template>
    <div class="container">
        <h1 class="text-center">Images list</h1>
        <div class="row">
            <div class="col-12" v-for="(item, index) in list" :key="index">
                <img :src="item.path" :alt="item.original_name" width="300" height="auto">
            </div>
        </div>

        <infinite-loading @infinite="infiniteHandler"></infinite-loading>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        data() {
            return {
                page: 1,
                list: [],
            };
        },
        methods: {
            infiniteHandler($state) {
                axios.get('get-images', {
                    params: {
                        page: this.page,
                    },
                }).then(({ data }) => {
                    if (data.length) {
                        this.page += 1;
                        this.list.push(...data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
        },
    }
</script>
