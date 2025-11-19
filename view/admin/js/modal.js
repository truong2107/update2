console.log("hiiii");
function showProductDetail(productId) {
  fetch(`/web/view/user/ProductDetail.php?product_id=${productId}`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("product-detail-content").innerHTML = data;
      document.getElementById("product-detail-popup").style.display = "block";
      document.getElementById("product-overlay").style.display = "block";
    });
}

function closeProductDetail() {
  document.getElementById("product-detail-popup").style.display = "none";
  document.getElementById("product-overlay").style.display = "none";
}

// === MODAL THÔNG BÁO LỖI ĐĂNG NHẬP ===
function showNotSignInModal(message) {
  createModal(message, "/web/view/user/SignIn.php", "Đăng nhập");
}

function showAddToCartModal(message) {
  createModal(message, "/web/index.php?act=viewCart", "Xem giỏ hàng");
}
function changeAccSuccesss(message) {
  createModal2(message, "/web/view/admin/accountManage.php", "chấp nhận");
}
function addProduct(message) {
  createModal2(message, "/web/view/admin/admin.product.php", "chấp nhận");
}
function editProduct(message) {
  createModal2(message, "/web/view/admin/admin.product.php", "chấp nhận");
}

// === HÀM TẠO MODAL DÙNG CHUNG ===
function createModal(message, linkHref, linkText) {
  const modalContainer = document.createElement("div");
  modalContainer.id = "modal-container";

  modalContainer.innerHTML = `
    <div class="modal" id="modal-demo">
      <div class="modal_header">
        <h3>Thông báo</h3>
        <button id="btn-close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal_body">
        <p>${message}</p>
        <a href="${linkHref}">${linkText}</a>
      </div>
    </div>
  `;

  document.body.appendChild(modalContainer);

  const btnClose = document.getElementById("btn-close");
  const modalDemo = document.getElementById("modal-demo");

  modalContainer.classList.add("show");

  btnClose.addEventListener("click", function () {
    modalContainer.classList.remove("show");
    setTimeout(() => document.body.removeChild(modalContainer), 300);
  });

  modalContainer.addEventListener("click", function (e) {
    if (!modalDemo.contains(e.target)) btnClose.click();
  });

  // === THÊM CSS CHO MODAL (nếu chưa có) ===
  if (!document.getElementById("modal-style")) {
    const style = document.createElement("style");
    style.id = "modal-style";
    style.textContent = `
      * { box-sizing: border-box; }
      body { font-family: Arial, Helvetica, sans-serif; line-height: 1.3; }

      #modal-container {
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0; left: 0;
        width: 100%;
        opacity: 0;
        pointer-events: none;
        z-index: 1000;
      }
      #modal-container.show { opacity: 1; pointer-events: all; }

      .modal {
        background-color: #fff;
        max-width: 500px;
        position: relative;
        left: 50%; top: 100px;
        transform: translateX(-50%);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }

      .modal .modal_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid gray;
      }

      .modal_header h3 {
        margin: 0;
        text-align: center;
        flex-grow: 1;
      }

      button#btn-close {
        width: 30px; height: 30px;
        border: none;
        font-size: 20px;
        color: white;
        background-color: #f37319;
        border-radius: 20px;
        cursor: pointer;
        position: absolute;
        top: -5px; right: -5px;
      }

      .modal .modal_body { padding: 10px 20px 15px; }

      .modal_body p { text-align: center; }

      .modal_body a {
        text-decoration: none;
        background: #f37319;
        color: #fff;
        display: block;
        padding: 5px 15px;
        text-align: center;
        margin: 10px auto;
        width: fit-content;
        border-radius: 10px;
      }
    `;
    document.head.appendChild(style);
  }
}
function createModal2(message, linkHref, linkText) {
  const modalContainer = document.createElement("div");
  modalContainer.id = "modal-container";

  modalContainer.innerHTML = `
    <div class="modal" id="modal-demo">
      <div class="modal_header">

        <h3>Thông báo</h3>

        <button id="btn-close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal_body">
        <img src="../img/phucdu2.jpg" alt="phucdu" style="width:150px;height:150px;">
        <p>${message}</p>
        <a href="${linkHref}">${linkText}</a>
      </div>
    </div>
  `;

  document.body.appendChild(modalContainer);

  const btnClose = document.getElementById("btn-close");
  const modalDemo = document.getElementById("modal-demo");

  modalContainer.classList.add("show");

  btnClose.addEventListener("click", function () {
    modalContainer.classList.remove("show");
    setTimeout(() => document.body.removeChild(modalContainer), 300);
  });

  modalContainer.addEventListener("click", function (e) {
    if (!modalDemo.contains(e.target)) btnClose.click();
  });

  // === THÊM CSS CHO MODAL (nếu chưa có) ===
  if (!document.getElementById("modal-style")) {
    const style = document.createElement("style");
    style.id = "modal-style";
    style.textContent = `
      * { box-sizing: border-box; }
      body { font-family: Arial, Helvetica, sans-serif; line-height: 1.3; }

      #modal-container {
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0; left: 0;
        width: 100%;
        opacity: 0;
        pointer-events: none;
        z-index: 1000;
      }
      #modal-container.show { opacity: 1; pointer-events: all; }

      .modal {
        background-color: #fff;
        max-width: 500px;
        position: relative;
        left: 50%; top: 100px;
        transform: translateX(-50%);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }

      .modal .modal_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid gray;
      }

      .modal_header h3 {
        margin: 0;
        text-align: center;
        flex-grow: 1;
      }

      button#btn-close {
        width: 30px; height: 30px;
        border: none;
        font-size: 20px;
        color: white;
        background-color: #f37319;
        border-radius: 20px;
        cursor: pointer;
        position: absolute;
        top: -5px; right: -5px;
      }

      .modal .modal_body { 
      padding: 10px 20px 15px;
        display: flex;
  flex-direction: column;
  align-items: center;
      }

      .modal_body p { text-align: center; }

      .modal_body a {
        text-decoration: none;
        background: #f37319;
        color: #fff;
        display: block;
        padding: 5px 15px;
        text-align: center;
        margin: 10px auto;
        width: fit-content;
        border-radius: 10px;
      }
    `;
    document.head.appendChild(style);
  }
}
