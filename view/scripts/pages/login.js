const form = document.getElementsByTagName('form')[0];
const statusPara = document.getElementById('status');
const inputEls =  document.querySelectorAll('input:not([type=submit])');

function checkLogin(e) {
  e.preventDefault();

  const headers = {
    method: "POST",
    body: new FormData(form)
  }


  fetch('/api/login.php', headers).then(res => {
    if (!res.ok)
      throw new Error(`HTTP error! Status ${res.status}`);
    return res.json();

  }).then(showRes);
}



function showRes(responseJSON) {
  let status, res;
  ({ status, res } = responseJSON);

  statusPara.textContent = res;

  const color = status == 1 ? 'green' : 'red';
  statusPara.style.color = color;

  if (status == 1) changeFilePath();
}


function changeFilePath() {
  const filePath = location.href;
  const dirPath = filePath.substring(0, filePath.lastIndexOf("/") + 1);
  const dashboardPage = dirPath + '../dashboard.php';
  location.href = dashboardPage;
}

form.addEventListener('submit', checkLogin);