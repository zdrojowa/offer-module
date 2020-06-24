<template>
    <div>
        <slot></slot>

        <b-nav align="right">
            <b-nav-item>
                <b-button type="button" variant="primary" @click="save">Zapisz</b-button>
            </b-nav-item>
        </b-nav>

        <div class="row">
            <div class="form-group col-sm-12">
                <div class="form-group">
                    <label>Hotele</label>
                    <multiselect v-model.lazy="hotels" :options="objects.hotels" :group-select="true" group-values="values" group-label="group" track-by="_id" label="name" placeholder="Wybierz hotel" :multiple="true" :searchable="true"></multiselect>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'objects',
        props : ['_id'],

        data() {
            return {
                hotels: [],
                objects: {
                    hotels: [{
                        group: 'Hotele',
                        values: []
                    }]
                }
            };
        },

        created() {
            this.getHotels();
        },

        methods: {

            getHotels: function() {
                axios.get('/api/hotels')
                    .then(res => {
                        this.objects.hotels[0].values = res.data;console.log(this.objects);
                        this.getOffer();
                    }).catch(err => {
                    console.log(err)
                })
            },

            getOffer: function() {
                let self = this;
                if (self._id) {
                    axios.get('/api/offers?id=' + self._id)
                        .then(res => {
                            if (res.data.hotels != null) {
                                res.data.hotels.forEach(item => {
                                    self.objects.hotels[0].values.forEach(hotel => {
                                        if (hotel._id === item) {
                                            self.hotels.push(hotel);
                                        }
                                    });
                                });
                            }
                        }).catch(err => {
                        console.log(err);
                    })
                }
                self.checkLangs();
            },

            save: function(e) {
                e.preventDefault();

                let formData = new FormData();
                formData.append('_method','PUT');
                formData.append('hotels', JSON.stringify(this.hotels));

                axios.post('/dashboard/offers/' + this._id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(res => {
                        this.$bvToast.toast('Objekty zaktualizowane', {
                            title: `Objekty`,
                            variant: 'success',
                            solid: true
                        })
                    }).catch(err => {
                        this.$bvToast.toast(err, {
                            title: `Błąd`,
                            variant: 'danger',
                            solid: true
                        })
                });
            }
        }
    }
</script>
