const { createApp, reactive, ref, onMounted } = Vue;

createApp({
  setup() {
    const data = reactive({
      myModal: false,
      allData: "",
      actionButton: "Insert",
      title: "",
      hiddenId: "",
    });

    axios
      .post("./action.php", {
        action: "fetchAll",
      })
      .then((result) => {
        data.allData = result.data;
      });

    const openModal = () => {
      data.myModal = true;
      data.title = "";
      data.actionButton = "Insert";
    };

    const submitData = () => {
      if (data.title != "") {
        console.log("uuu");
        if (data.actionButton == "Insert") {
          axios
            .post("./action.php", {
              action: "insert",
              title: data.title,
            })
            .then((result) => {
              (data.myModal = false), fetchAllData();
              data.title = "";
              alert(result.data.message);
            });
        }

        if (data.actionButton == "Update") {
          axios
            .post("./action.php", {
              action: "update",
              title: data.title,
              id: data.hiddenId,
            })
            .then((result) => {
              (data.myModal = false),
                fetchAllData(),
                (data.title = ""),
                (data.hiddenId = ""),
                alert(result.data.message);
            });
        }
      }
    };

    const fetchAllData = () => {
      axios
        .post("./action.php", {
          action: "fetchAll",
        })
        .then((result) => {
          data.allData = result.data;
        });
    };

    const deleteData = (id) => {
      axios
        .post("./action.php", {
          action: "delete",
          id: id,
        })
        .then((result) => {
          fetchAllData();
          alert(result.data.message);
        });
    };

    const fetchData = (id) => {
      data.hiddenId = id;
      (data.myModal = true), (data.actionButton = "Update");

      // console.log(data.hiddenId)
      // axios.post('./action.php', {
      //   action: 'fetchSingle',
      //   id: id
      // }).then((result) => {
      //   // console.log('iu')
      //   // data.title = result.data.title
      //   // data.hiddenId = result.data.id
      // })
    };

    return {
      data,
      deleteData,
      openModal,
      submitData,
      fetchData,
    };
  },
}).mount("#app");
