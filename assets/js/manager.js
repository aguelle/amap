//add Grower
const growerForm = document.getElementById("growerForm");

document
  .getElementById("displayGrowerForm")
  .addEventListener("click", function (event) {
    event.preventDefault();
    growerForm.classList.toggle("hidden");
  });
document
  .getElementById("addGrower")
  .addEventListener("click", function (event) {
    event.preventDefault();
    const data = {
      action: "addGrower",
      token: getToken(),
      lastname: document.getElementById("lastname").value,
      firstname: document.getElementById("firstname").value,
      email: document.getElementById("email").value,
      business: document.getElementById("business").value,
    };
    console.log(data);
    fetchApi("POST", data)
      .then((data) => {
        console.log(data);
        location.reload();
        growerForm.classList.add("hidden");
      })
      .catch((error) => {
        console.error("Error: ", error);
      });
  });

//add product
const productAdd = document.querySelectorAll("#displayProductForm");
const productForm = document.getElementById("productForm");
productAdd.forEach(btn => {
  btn.addEventListener("click", function (event) {
    console.log(event.target)
    event.preventDefault();
    // console.log(
    //   btn.dataset.idGrower,
    //   productForm.dataset.idGrower
    // );
    if (
        btn.dataset.idGrower === productForm.dataset.idGrower
    ) {
      productForm.classList.toggle("hidden");
    }
  });
});

document.getElementById("displayProductForm").addEventListener("click", function (event) {
    event.preventDefault();
  });
document
  .getElementById("addProduct")
  .addEventListener("click", function (event) {
    event.preventDefault();
    const data = {
      action: "addProduct",
      token: getToken(),
      name: document.getElementById("product__name").value,
    };
    console.log(data);
    fetchApi("POST", data)
      .then((data) => {
        console.log(data);
        location.reload();
        productForm.classList.add("hidden");
      })
      .catch((error) => {
        console.error("Error: ", error);
      });
  });

const deleteBtns = document.querySelectorAll("#deleteBtn");

deleteBtns.forEach((btn) => {
  btn.addEventListener("click", function (event) {
    event.preventDefault();
    const id = parseInt(this.closest("[data-id-product]").dataset.idProduct);
    const data = {
      action: "deleteProduct",
      token: getToken(),
      id: id,
    };
    console.log(data);
    fetchApi("POST", data)
      .then((data) => {
        console.log(data);
        // document.querySelector(`[data-id-product="${id}"]`).remove();
      })
      .catch((error) => {
        console.error("Error: ", error);
      });
  });
});
