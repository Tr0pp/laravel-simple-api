<template>
    <div class="container">
        <div class="row justify-content-center pt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Firebase</div>
                    <div class="card-body">
                        <label for="search-firebase">Nome do banco</label>
                        <input id="search-firebase" type="text" v-model="nameFirebase" v-on:keyup.enter="searchFirebase">

                        <label for="search-leilao-id">Leilão id</label>
                        <input id="search-leilao-id" type="text" v-model="leilaoId" v-on:keyup.enter="searchFirebase(true)">

                        <label for="search-no">Selecione um nó</label>
                        <select id="search-no" v-model="noTipo" v-on:select="searchFirebase">
                            <option disabled value="">Nó</option>
                            <option value="destaque">Destaque</option>
                            <option value="geral">Geral</option>
                            <option value="leilao" selected>Leilão</option>
                            <option value="lote">Lote</option>
                            <option value="lance">Lance</option>
                            <option value="paramsite">Paramsite</option>
                            <option value="status">Status</option>
                        </select>

                        <div class="card-body">
                            <pre>
                                {{ leiloes }}
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            leiloes: [],
            nameFirebase: '',
            leilaoId: '',
            noTipo: '',
        }
    },
    async created() {
        this.leiloes = "Procurando..."
        await axios(`http://127.0.0.1:8000/api/firebase`).then((res) => {
           this.leiloes = res.data;
        }).catch((err) => {
            this.error = err
        })
    },
    methods: {
        searchFirebase(useId, useCampo){
            this.leiloes = "Procurando..."
            let id = ''

            if(useId){
                id = `/${this.leilaoId}`
            }

            axios(`http://127.0.0.1:8000/api/firebase${id}?name=${this.nameFirebase}&type=${this.noTipo}`).then((res) => {
                if(res.data.error){
                    this.leiloes = "Leiloeiro não encontrado";
                }
                this.leiloes = res.data
            }).catch((err) => {
                this.leiloes = err
            })
        }
    }

}
</script>

<style scoped>

</style>
