
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<div class="container" id="app" >
  <div class="col-md-6">
    <input type="button" class="btn btn-success btn-xs" @click="openModal" value="Add">
  </div>
  <table class="table table-bordered table-striped">
    <tr>
      <th>id</th>
      <th>title</th>
      <th>edit</th>
      <th>delete</th>
    </tr>
    <tr v-for="row in data.allData" :key="row">
      <td>{{ row.id }}</td>
      <td>{{ row.title }}</td>
      <td><button name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(row.id)">edit</button></td>
      <td><button name="delete" class="btn btn-danger btn-xd delete" @click="deleteData(row.id)">delete</button></td>
    </tr>
  </table>
  <div v-if="data.myModal">
    <transition name="model">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <div class="form-group">
                  <label>Enter title</label>
                  <input type="text" class="form-control" v-model="data.title" />
                </div>
                <div>
                  <input type="hidden" v-model="data.hiddenId">
                  <input type="button" class="btn btn-success btn-xs" v-model="data.actionButton" @click="submitData" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
   </div>
</div>

<style>
     .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   }
</style>

<script src="./main.js"></script>