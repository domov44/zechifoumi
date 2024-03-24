function showPassword(fieldId, eyeIconId) {
    let field = document.getElementById(fieldId);
    let eyeIcon = document.getElementById(eyeIconId);

    if (field.type === "password") {
        field.type = "text";
        eyeIcon.className = "fa-regular fa-eye";
    } else {
        field.type = "password";
        eyeIcon.className = "fa-regular fa-eye-slash";
    }
}


function afficherToast(contenu, type) {
    var baseImagePath = '';
    if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
        baseImagePath = '/zechifoumi/uploads/icon/';
    } else {
        baseImagePath = '/uploads/icon/';
    }

    var successImagePath = baseImagePath + 'cocher.svg';
    var errorImagePath = baseImagePath + 'close.svg';

    Toastify({
        avatar: type === "success" ? successImagePath : (type === "error" ? errorImagePath : "#FF5733"),
        text: contenu,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: true,
        style: {
            color: type === "success" ? "var(--success-color)" : "error" ? "rgb(255, 109, 116)" : "#FF5733",
            background: type === "success" ? "var(--success-bg)" : "error" ? "rgba(250, 179, 169, 0.1)" : "#FF5733",
            borderLeft: "2px solid",
            borderColor: type === "success" ? "var(--success-color)" : "error" ? "rgb(255, 109, 116)" : "#FF5733",
            boxShadow: "none",
        },
    }).showToast();
}



function togglePopup() {
    var popup = document.getElementById("addUserPopup");
    popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";

    if (popup.style.display === "block") {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("popupContent").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "add_user.php", true);
        xmlhttp.send();
    }
}

function toggleModifyPopup(userId) {
    var modifyPopup = document.getElementById("modifyUserPopup");
    modifyPopup.style.display = (modifyPopup.style.display === "none" || modifyPopup.style.display === "") ? "block" : "none";

    if (modifyPopup.style.display === "block") {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("EditContent").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "modify_user.php?user_id=" + userId, true);
        xmlhttp.send();
    }
}

function showModal(title, text, callback) {
    var overlay = document.createElement('div');
    overlay.className = 'overlay';

    var modal = document.createElement('div');
    modal.className = 'popup';
    modal.innerHTML = `
        <h2>${title}</h2>
        <p>${text}</p>
        <div class="button-container">
        <button class="button-secondary" id="cancelBtn">No, cancel</button>
        <button class="button" id="confirmBtn">Yes, confirm</button>
        </div>
    `;

    overlay.onclick = function () {
        hideModal(overlay, modal);
        callback(false);
    };

    modal.querySelector('#cancelBtn').onclick = function () {
        hideModal(overlay, modal);
        callback(false);
    };

    modal.querySelector('#confirmBtn').onclick = function () {
        hideModal(overlay, modal);
        callback(true);
    };

    overlay.appendChild(modal);

    document.body.appendChild(overlay);

    overlay.style.display = 'block';
    modal.style.display = 'block';
}

function hideModal(overlay, modal) {
    overlay.style.display = 'none';
    modal.style.display = 'none';

    if (overlay.parentNode) {
        overlay.parentNode.removeChild(overlay);
    }

    if (modal.parentNode) {
        modal.parentNode.removeChild(modal);
    }
}


function confirmDelete(userId, confirmationText) {
    showModal('Deletion Confirmation', confirmationText, function (confirmed) {
        if (confirmed) {
            document.querySelector('.deleteForm input[name="user_id"]').value = userId;
            document.querySelector('.deleteForm').submit();
        }
    });
}