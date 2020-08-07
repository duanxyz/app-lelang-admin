<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="listQuery.keyword"
        placeholder="Nama barang"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-select
        v-model="listQuery.category"
        placeholder="kategori"
        clearable
        style="width: 90px"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option v-for="item in items" :key="item" :label="item | uppercaseFirst" :value="item" />
      </el-select>
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >{{ $t('table.search') }}</el-button>
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >Tambah</el-button>
    </div>

    <el-table
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >
      <el-table-column align="center" label="ID" width="60">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Nama Barang" width="170px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.item_name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Kategori" width="100px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.category }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Harga Awal" width="120px" align="center">
        <template slot-scope="scope">
          <span>Rp. {{ formatPrice(scope.row.initial_price) }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Foto" width="150px" align="center">
        <template slot-scope="scope">
          <!-- <span>{{ scope.row.photo }}</span> -->
          <el-image
            :src="'/images/items/'+scope.row.photo"
            @click="setSrcList('/images/items/'+scope.row.photo)"
          />
        </template>
      </el-table-column>
      <el-table-column label="Deskripsi" width="180px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.deskripsi }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Jadwal Lelang" width="130px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.auction_date | parseTime('{y}-{m}-{d}') }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Waktu Lelang" width="120px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.auction_time }}</span>
        </template>
      </el-table-column>
      <el-table-column label="status" class-name="status-col" width="120">
        <template slot-scope="{row}">
          <el-tag :type="row.status | statusFilter">{{ row.status }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="189" fixed="right">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            icon="el-icon-edit"
            @click="handleEditForm(scope.row.id, scope.row.item_name);"
          >Edit</el-button>
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.item_name);"
          >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <el-dialog :title="dialogStatus" :visible.sync="dialogFormVisible">
      <div v-loading="itemCreating" class="form-container">
        <el-form
          ref="itemForm"
          :model="newItem"
          label-position="left"
          label-width="150px"
          style="max-width: 500px;"
          enctype="multipart/form-data"
        >
          <el-form-item label="Nama Barang" prop="item_name">
            <el-input v-model="newItem.item_name" />
          </el-form-item>
          <el-form-item label="Kategori" prop="category">
            <el-input v-model="newItem.category" />
          </el-form-item>
          <el-form-item label="Harga Awal" prop="initial_price">
            <el-input v-model="newItem.initial_price" />
          </el-form-item>
          <el-form-item label="Deskripsi" prop="deskripsi">
            <el-input v-model="newItem.deskripsi" type="textarea" autosize />
          </el-form-item>
          <el-form-item label="Tanggal Lelang">
            <el-col :span="11">
              <el-date-picker
                v-model="newItem.auction_date"
                type="date"
                placeholder="Pilih tanggal"
                style="width: 100%;"
                format="yyyy/MM/dd"
                value-format="yyyy-MM-dd"
              />
            </el-col>
            <el-col :span="2" class="line" />
            <el-col :span="11">
              <el-time-picker
                v-model="newItem.auction_time"
                type="fixed-time"
                placeholder="Pilih waktu"
                style="width: 100%;"
                value-format="hh:mm"
              />
            </el-col>
          </el-form-item>
          <el-form-item label="Foto" prop="photo">
            <input type="file" @change="onImageChange">
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
          <el-button type="primary" @click="handleSubmit()">{{ $t('table.confirm') }}</el-button>
        </div>
      </div>
    </el-dialog>
    <el-dialog :visible.sync="imageVisible">
      <el-image :src="img" />
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
const itemResource = new Resource('items');

export default {
  // name: 'MemberTable',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        NotVerified: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      itemCreating: false,
      listQuery: {
        page: 1,
        limit: 15,
        keyword: '',
      },
      statusOptions: ['published', 'draft', 'Not Verified'],
      downloadLoading: false,
      dialogFormVisible: false,
      imageVisible: false,
      image: '',
      newItem: {},
      dialogStatus: '',
      items: ['perhiasan', 'kendaraan', 'sertifikat', 'elektronik'],
      img: '',
      textMap: {
        update: 'Edit',
        create: 'Create',
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      // this.listLoading = true;
      // const { data } = await itemResource.list({});
      // this.list = data;
      // // const { data } = await itemResource.list(this.listQuery);
      // // this.list = data.items;
      // // this.total = data.total;

      // // Just to simulate the time of the request
      // this.listLoading = false;
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data, meta } = await itemResource.list(this.listQuery);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.listLoading = false;
    },
    setSrcList(photo) {
      this.img = photo;
      this.imageVisible = true;
    },
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
      this.newItem.photo = this.image;
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    handleCreate() {
      this.resetNewItem();
      this.dialogStatus = 'Tambah barang';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['itemForm'].clearValidate();
      });
    },
    handleEditForm(id) {
      this.dialogStatus = 'Ubah barang';
      this.newItem = this.list.find(item => item.id === id);
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['itemForm'].clearValidate();
      });
    },
    handleDelete(id, name) {
      this.$confirm(
        'Ini akan menghapus barang secara permanen ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          itemResource
            .destroy(id)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.getList();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },
    handleSubmit() {
      this.$refs['itemForm'].validate(valid => {
        if (valid) {
          const data = new FormData();
          data.append('photo', this.image);
          data.append('deskripsi', this.newItem.deskripsi);
          data.append('item_name', this.newItem.item_name);
          data.append('category', this.newItem.category);
          data.append('initial_price', this.newItem.initial_price);
          data.append('auction_date', this.newItem.auction_date);
          data.append('auction_time', this.newItem.auction_time);
          const config = {
            headers: { 'content-type': 'multipart/form-data' },
          };
          if (this.newItem.id !== undefined) {
            data.append('_method', 'put');
            this.itemCreating = true;
            itemResource
              .updatePost(this.newItem.id, data, config)
              .then(response => {
                this.$message({
                  message:
                    'Barang ' +
                    this.newItem.item_name +
                    ' telah berhasil diubah.',
                  type: 'success',
                  duration: 5 * 1000,
                });
                this.resetNewItem();
                this.image = '';
                this.dialogFormVisible = false;
                this.handleFilter();
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.itemCreating = false;
              });
          } else {
            this.itemCreating = true;
            itemResource
              .store(data, config)
              .then(response => {
                this.$message({
                  message:
                    'Barang baru ' +
                    this.newItem.item_name +
                    ' telah berhasil dibuat.',
                  type: 'success',
                  duration: 5 * 1000,
                });
                this.resetNewItem();
                this.image = '';
                this.dialogFormVisible = false;
                this.handleFilter();
              })
              .catch(error => {
                console.log(error);
              })
              .finally(() => {
                this.itemCreating = false;
              });
          }
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    resetNewItem() {
      this.newItem = {
        item_name: '',
        category: '',
        deskripsi: '',
        photo: '',
        initial_price: '',
        auction_date: '',
        auction_time: '',
      };
    },
    formatPrice(value) {
      const val = (value / 1).toFixed(2).replace('.', ',');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    // indexMethod(index) {
    //   return index + 1;
    // },
  },
};
</script>
