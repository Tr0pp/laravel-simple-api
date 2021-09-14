<template>
    <div class="container">
        <div class="row justify-content-center pt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Firebase</div>
                    <div class="card-body">
                        <label for="search-firebase">Nome do banco</label>
                        <input id="search-firebase" type="text" v-model="nameFirebase" @keyup.enter="searchFirebase">

                        <label for="search-leilao-id">Leilão id</label>
                        <input id="search-leilao-id" type="text" v-model="leilaoId" @keyup.enter="searchFirebase(true)">

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
                            <div v-if="resultado === true">
                                <div v-for="(info, idx) in infoBanco">
                                    <div class="header" @click="toggleExpansion(idx)">
                                        {{ idx }}
                                    </div>
                                    <div class="content" v-show="isExpanded(idx)">
                                        <pre>{{ info }}</pre>
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
export default {
    data() {
        return {
            infoBanco: [],
            nameFirebase: '',
            leilaoId: '',
            noTipo: '',
            resultado: false,
            expandedGroup: []
        }
    },
    async created() {
        await axios(`http://127.0.0.1:8000/api/firebase`).then((res) => {
           this.infoBanco = res.data
           this.resultado = true
        }).catch((err) => {
            this.error = err
        })
    },
    methods: {
        searchFirebase(useId, useCampo){
            let id = ''

            if(useId){
                id = `/${this.leilaoId}`
            }

            axios(`http://127.0.0.1:8000/api/firebase${id}?name=${this.nameFirebase}&type=${this.noTipo}`).then((res) => {
                this.infoBanco = res.data
                this.resultado = true
            }).catch((err) => {
                this.infoBanco = err
            })
        },
        isExpanded(key) {
            return this.expandedGroup.indexOf(key) !== -1;
        },
        toggleExpansion(key) {
            if (this.isExpanded(key))
                this.expandedGroup.splice(this.expandedGroup.indexOf(key), 1);
            else
                this.expandedGroup.push(key);
        }
    }

}
</script>

<style scoped>
.header {
    background-color:#d3d3d3;
    padding: 2px;
    cursor: pointer;
    font-weight: bold;
    border: #5a6268 solid 1px;
    border-radius: 3px;
}
.content {
    background-color: #e0e0e0;
    padding : 5px;
}

#toggle {
    display: block;
}
</style>
