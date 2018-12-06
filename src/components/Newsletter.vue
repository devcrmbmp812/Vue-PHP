<template>
<div>
    <b-card style="border:none;"
          class="col-md-4 offset-md-4" title="Suscribite a nuestro Newsletter">
          <b-alert variant="success" :show="show">{{message}}</b-alert>
        <b-form-group
            id="fieldset1"
            label="Su nombre"
            label-for="input1"
            :invalid-feedback="invalidFeedback"
            :valid-feedback="validFeedback"
            :state="state">
            <b-form-input id="input1" :state="state" v-model.trim="name"></b-form-input>
        </b-form-group>
        <b-form-group
            id="fieldset2"
            label="Su email"
            label-for="input2"
            :invalid-feedback="invalidFeedback2"
            :valid-feedback="validFeedback2"
            :state="state2">
            <b-form-input id="input2" :state="state2" type="email" v-model.trim="email"></b-form-input>
        </b-form-group>
        <b-btn class="mt-3" variant="outline-success" block @click="submitData">Suscribirme</b-btn>
        </b-card>
        
  </div>
</template>
<script>
export default {
  name: 'Newsletter',
    data: function() {
        return {
            name : '',
            email: '',
            message : '',
            show : false
        }
    },
    computed: {
		state () {
			return this.name.length >= 4 ? true : false
		},
		invalidFeedback () {
			if (this.name.length > 4) {
				return ''
			} else if (this.name.length > 0) {
				return 'Ingrese mas de 4 caracteres'
			} else {
				return 'Por favor escriba su nombre'
			}
		},
        state2 () {
			return this.email.length >= 4 ? true : false
		},
		invalidFeedback2 () {
			if (this.email.length > 4) {
				return ''
			} else if (this.email.length > 0) {
				return 'Email invalido'
			} else {
				return 'Por favor escriba su email'
			}
		}
    },
    methods :{
        submitData() {
			var name = this.name;
            var email = this.email;
            var ele = this;
            if(name == '' || email == ''){
				return false;
			}
			else{
				this.$store.dispatch('addNewsletterFromAPI',{
					'name' : name,
					'email' : email
				})
				.then(response => response.json())
				.then(data => {
                    if(data.status == 1)
					{
                        this.message = data.msg;
                        ele.show = true;
                    }
				});
			}
		}
    }
}
</script>