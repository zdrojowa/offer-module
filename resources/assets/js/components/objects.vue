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
                    <multiselect v-model.lazy="objects" :options="options" :group-select="true" group-values="values" group-label="group" track-by="id" label="name" placeholder="Wybierz objekty" :multiple="true" :searchable="true"></multiselect>
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
                objects: [],
                options: []
            };
        },

        created() {
            this.getHotels();
        },

        methods: {

            getHotels: function() {
                axios.get('/api/hotels')
                    .then(res => {
                        let values = [];
                        res.data.forEach(item => {
                            values.push({id: item._id, name: item.name, type: 'hotels'});
                        });
                        this.options.push({group: 'Hotele', values: values});
                        this.getWellness();
                    }).catch(err => {
                    console.log(err)
                })
            },

            getWellness: function() {
                axios.get('/api/hotels/wellness')
                .then(res => {
                    let values = [];
                    res.data.forEach(item => {
                        values.push({id: item._id, name: item.name, type: 'wellness'});
                    });
                    this.options.push({group: 'Wellness', values: values});
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
                        if (res.data.objects != null) {
                            self.objects = res.data.objects;
                        }
                    }).catch(err => {
                        console.log(err);
                    })
                }
            },

            save: function(e) {
                e.preventDefault();

                let formData = new FormData();
                formData.append('_method','PUT');
                formData.append('objects', JSON.stringify(this.objects));

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
