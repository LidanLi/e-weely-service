<template>
   
    <div class="column">

      <draggable
        :list="list"
        :disabled="!enabled"
        class="list-group"
        ghost-class="ghost"
        @start="dragging = true"
        @end="dragging = false"
        @change="updateAll"
      >    
       <div
          class="columns is-mobile"
          v-for="element in list"
          :key="element.name"
        >
        <div class="column is-three-quarters">
         <a v-bind:href="'../storage/' + element.file">{{ element.name }}</a>
         </div>
          
         <div class="column">
            <form method="post" :action="'/events/' + event + '/documents/' + element.id + '/remove'">
               <input type="hidden" name="_method" value="delete">
               <input type="hidden" name="_token" :value="csrf_token">
                <button class="button is-link">Remove</button>
            </form>
          </div> 
        </div>
      
      </draggable>
    </div>

   
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
      name: "simple",
      display: "Simple",
      order: 0,
        components: {
            draggable
        },

       props: ['event', 'csrf_token'],

        data() {
            return {
              enabled: true,
              list: [],           
              dragging: false
            };
        },

        mounted() {
            axios.get('/api/events/' + this.event + '/documents/current')
                .then((response) => {
                    this.list = response.data;
                });
        },

        methods: {
            updateAll(){

            var ids = [];
            let mylist = this.list;
            for (let index = 0; index < mylist.length; index++ ){
              ids[index] = mylist[index].id;
            }
            console.log(ids);
            axios.get('/api/events/' + this.event + '/documents/updated/' + ids.toString())
              .then((response) => {
                  console.log(response.data);
              });
            }

         

        }
    }
</script>
