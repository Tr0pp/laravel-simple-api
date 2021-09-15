<template>
    <div class="container">
        <div class="row justify-content-center pt-5 mb-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Firebase</div>
                    <div class="card-body">
                        <label for="search-firebase">Nome do banco
                            <input id="search-firebase" type="text" v-model="nameFirebase" @keyup.enter="searchFirebase">
                        </label>

                        <label for="search-leilao-id">Leilão ID
                            <input id="search-leilao-id" type="text" v-model="leilaoId" @keyup.enter="searchFirebase(true)">
                        </label>

                        <label for="search-no">Nó
                            <select id="search-no" v-model="noTipo" v-on:select="searchFirebase">
                                <option disabled value=""> -- </option>
                                <option value="destaque">Destaque</option>
                                <option value="geral">Geral</option>
                                <option value="leilao" selected>Leilão</option>
                                <option value="lote">Lote</option>
                                <option value="lance">Lance</option>
                                <option value="paramsite">Paramsite</option>
                                <option value="status">Status</option>
                            </select>
                        </label>
                        <div class="card-body">
                            <div v-if="resultado === true">
                                <div v-for="(info, idx) in infoBanco">
                                    <div class="header" @click="toggleExpansion(idx)">
                                        {{ idx }}
                                    </div>
                                    <div class="content" v-show="isExpanded(idx)">
                                        <div v-for="(dados, idxDados) in info">
                                            <div v-if="Array.isArray(dados) === true">
                                                <div class="header-info" @click="toggleExpansion(idxDados)">
                                                    {{ idxDados }}
                                                </div>
                                                <div class="content" v-show="isExpanded(idxDados)">
                                                    <pre class="border-block">{{ idxDados }}: {{ dados }}</pre>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <pre class="border-block">{{ idxDados }}: {{ dados }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <p class="searching">Procurando...</p>
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
    background-color: #7adaff;
    padding: 2px;
    margin-bottom: 2px;
    cursor: pointer;
    font-weight: bold;
    border: #336175 solid 1px;
    border-radius: 3px;
    color: #000;

}

.header-info {
    background-color: #989898;
    padding: 2px;
    margin-bottom: 2px;
    margin-top: 2px;
    margin-left: 8px;
    cursor: pointer;
    font-weight: bold;
    border: #4d4d4d solid 1px;
    border-radius: 3px;
    color: #fff;

}

.content {
    background-color: #f1f1f1;
    padding : 5px;
    border: #cccccc solid 1px;
    border-radius: 1.3px;
}

#toggle {
    display: block;
}

.searching {
    text-align: center;
}

.border-block {
    border: #b4b4b4 solid 0.5px;
    border-radius: 1.5px;
    padding: 1px;
}
</style>
