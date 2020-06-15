<template>
    <div>
        <slot></slot>

        <b-nav align="right">
            <b-nav-item>
                <b-button type="button" variant="primary" @click="save">Zapisz</b-button>
            </b-nav-item>
        </b-nav>

        <b-form-group label="Udogodnienia">
            <b-form-checkbox-group
                v-model="conveniences"
                :options="options"
                switches
                stacked
            ></b-form-checkbox-group>
        </b-form-group>
    </div>
</template>

<script>

    export default {
        name: 'offer-convenience',
        props : ['_id'],

        data() {
            return {
                conveniences: [],
                options: []
            };
        },

        created() {
            this.getConveniences();
        },

        methods: {

            getConveniences: function() {
                let self = this;

                axios.get('/api/offers-conveniences')
                    .then(res => {
                        res.data.forEach(item => {
                            self.options.push({text: item.name, value: item.id})
                        });
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
                            if (res.data.conveniences != null) {
                                self.conveniences = res.data.conveniences;
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
                formData.append('conveniences', JSON.stringify(this.conveniences));

                axios.post('/dashboard/offers/' + this._id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(res => {
                        window.location = res.data.redirect;
                    }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
