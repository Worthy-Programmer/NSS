const pfpForm = document.getElementById("pfp_form");
const input = form.pfpToUpload;
const pfpStatusPara = document.getElementById("pfp_status");
const img = document.getElementById("pfp");
const approvedType = ["image/jpeg", "image/png"];

const PFPFile = "../api/pfp.php";


form.addEventListener('change', fileUploadChange);
form.addEventListener('submit', uploadPFP);


/**
 * @param {Event} e
 */
function fileUploadChange(e) {
  statusPara.textContent = "";
  // @ts-ignore
  const file = e.target.files[0];

  if(file) {
    // console.log(file.type);
    if(!approvedType.includes(file.type)) {
      statusPara.style.color = "red";
      statusPara.textContent = "File type is not supported. Please upload PNG/JPEG format images";

      // @ts-ignore
      e.target.value="";
    }
  }
}

function uploadPFP(e) {
  e.preventDefault();

  fetch(PFPFile, {
    method: "POST",
    body: new FormData(form)
  })

  .then(res => res.json())
  .then(data =>  {
    console.log(data);
    if(data.status === 1) {
      statusPara.style.color = "green";
      // @ts-ignore
      pfp.src = PFPFile + "?" + new Date().getTime(); // To remove cache
    } else {
      statusPara.style.color = "red";
    }

    statusPara.textContent = data.res;

  }
  );
}

