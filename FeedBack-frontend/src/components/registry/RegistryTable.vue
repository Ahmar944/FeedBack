<template>
  <div class="table-container reg2-table" >
    <table
      class="table table-md-responsive">
      <thead>
        <tr>
          <th class="text-center">User Name<img src="../../assets/images/sort.png" alt="" class="sort-icon" @click="sort('user_name')"/></th>
          <th class="text-center">Email<img src="../../assets/images/sort.png" alt="" class="sort-icon" @click="sort('user_email')"/></th>
          <th>Title<img src="../../assets/images/sort.png" alt="" class="sort-icon" @click="sort('title')"/></th>
          <th class="text-center">Descrition<img src="../../assets/images/sort.png" alt="" class="sort-icon" @click="sort('description')"/></th>
          <th class="text-center">Category<img src="../../assets/images/sort.png" alt="" class="sort-icon" @click="sort('category')"/></th>
          <th class="text-center">Created Date<img class="sort-icon" src="../../assets/images/sort.png" alt="" @click="sort('created_at')"/></th>
          <th class="text-center" >Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(registry, index) in displayedRegistry" :key="index">
          
         
          <td class="text-center">
              <h6 class="company-name">{{ registry.user_name }}</h6>
          </td>
          <td class="text-center">
              <h6 class="company-name">{{ registry.user_email }}</h6>
          </td>
          <td >
            <div class="company-details">
              <h6 class="company-name">{{ registry.title }}</h6>
            </div>
          </td>
          <td class="text-center">
              <h6 class="company-name">{{ registry.description }}</h6>
          </td>
          
          <td v-if="registry.category == 1" class="text-center active">
                <button class="active">Feature</button>
          </td>
          <td v-else-if="registry.category == 2" class="text-center">
            <button class="terminated">Error</button>
          </td>
          <td v-else-if="registry.category == 3" class="text-center">
            <button class="notSigned">Improvement</button>
          </td>

          <td class="text-center">
              <h6 class="company-name">{{ registry.created_at | moment("MMM D, YYYY") }}</h6>
          </td>
          <td class="text-center">
             <button class="btn btn-primary" @click="openModal(registry)">Comments</button>  </td>         
          
        </tr>
      </tbody>
    </table>
    <modal/>
    <!-- <p v-else class="no-registry">No registry found.</p> -->
  </div>
</template>


<script>
import modal from '../comment/modal.vue'; // Adjust the import path as per your file structure

export default {
  name: "RegistryTable",
  components: {
    // comment,
    modal
    },
  props: {
    displayedRegistry:{
      typeof: Array
    } ,
    
  },

  data() {
    return {
      sortField: '',
      sortDirection: '',
      sortColumn: "created_at", 
      

      
    };
  },
  computed: {
    classObject: function () {
      return {
        'reg-table': this.message,
        'reg2-table': !this.message,
      }
    },
  },

  methods: {
    sort(field) {
      this.favoriteKey += 1;
      if (this.sortField === field) {
        // if already sorting by this field, toggle direction
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        // if sorting by a different field, reset direction to ascending
        this.sortField = field;
        this.sortDirection = 'asc';
      }
      // use Array.sort() to sort the displayedRegistry array
      this.displayedRegistry.sort((a, b) => {
        const aVal = this.getValue(a, field);
        const bVal = this.getValue(b, field);
        if (aVal < bVal) {
          return this.sortDirection === 'asc' ? -1 : 1;
        } else if (aVal > bVal) {
          return this.sortDirection === 'asc' ? 1 : -1;
        } else {
          return 0;
        }
      });
    },
    
    openModal(registry) {
      // Emit an event named 'open-modal' and pass the registry data
          this.$root.$emit("openBoxViewScoresModal", registry);
          
        },
    getValue(obj, field) {
      // Implement this method to retrieve the value of the specified field from the registry object
      // You can replace it with your own logic to extract the value
      return obj[field];
    }
  },
 
  mounted() {
    
  },
};
</script>
