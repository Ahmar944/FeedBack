<template>
  <div class="registry-wrapper-bottom">
    <h6>Total FeedBacks: {{ count }}</h6>
    <div class="bottom-right">
      <!-- <div class="dropdown"> -->
      <v-select
        v-model="filter.pageSize"
        :options="sizeList"
        label="text"
        :closeOnSelect="true"
        class="custom-select p-0"
        :placeholder="sizePlaceholder"
        :class="{ disabled: page.current_page === 1 }"
        auto
      >
      </v-select>
      <!-- </div> -->
      <nav aria-label="Page navigation example">
        <ul v-if="page" class="pagination">
          <li
            :class="{ disabled: page.current_page === 1 }"
            class="page-item previous-item"
          >
            <router-link
              :to="{ query: { page: page.current_page - 1 } }"
              class="page-link"
              ><img src="../../assets/images/left.png" alt=""
            /></router-link>
          </li>
          <li
            v-for="page in page.last_page"
            :key="page"
            :class="{ active: page.current_page === page }"
            class="page-item"
          >
            <router-link :to="{ query: { page: page } }" class="page-link">{{
              page
            }}</router-link>
          </li>
          <li
            :class="{ disabled: page.current_page === page.last_page }"
            class="page-item next-item"
          >
            <router-link
              :to="{ query: { page: page.current_page + 1 } }"
              class="page-link"
              ><img src="../../assets/images/right.png" alt=""
            /></router-link>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "RegistryBottom",
  props: {
    page: {
      typeof: Array
    },
    count: Number,
  },

  data() {
    return {
      rowsFilter: false,
      filter: { pageSize: "" },
      sizeList: [
        { text: "100" },
        { text: "200" },
        { text: "300" },
        { text: "400" },
        { text: "500" },
      ],
      sizePlaceholder: "SHOW",
    };
  },
  watch: {
    $data: {
      handler: function() {
        if (this.filter.pageSize != null) {
          this.$root.$emit("filtersCallForRegistry", this.filter);
        }
      },
      deep: true,
    },
  },
  methods: {
    openRowsFilter: function() {
      this.rowsFilter = !this.rowsFilter;
    },
    rowsFilterOutside: function() {
      this.rowsFilter = false;
    },
  },
};
</script>

<style></style>
