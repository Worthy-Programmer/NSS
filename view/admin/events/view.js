import TableRecords from "/view/scripts/components/TableRecords.js"
const tableRecord = new TableRecords('enrolled_users');
const markAttendanceBtn = document.getElementById('mark_attendance')
const unmarkAttendanceBtn = document.getElementById('unmark_attendance')
const deleteBtn = document.getElementsByClassName('delete_btn')[0];

tableRecord.deleteLink = 'user_event/delete_user.php'

tableRecord.setupEvents({
  deleteBtn,
  disableIfNotChecked: [deleteBtn, markAttendanceBtn, unmarkAttendanceBtn]
})

markAttendanceBtn.addEventListener('click', markAttendance)
unmarkAttendanceBtn.addEventListener('click', unmarkAttendance)

function markAttendance(_e) {
  tableRecord.sendSelectedRecordAndChangeUI('/api/user_event/attendance.php', checkedRecords =>
    checkedRecords.forEach(record => {
      console.log({
        record
      })
      const icon = record.parentElement.parentElement.getElementsByClassName('fas')[0]
      if (icon.classList.contains('fa-times')) icon.classList.remove('fa-times')
      icon.classList.add('fa-check')
    }), {
    role: 'mark'
  })
}

function unmarkAttendance(_e) {
  tableRecord.sendSelectedRecordAndChangeUI('/api/user_event/attendance.php', checkedRecords =>
    checkedRecords.forEach(record => {
      const icon = record.parentElement.parentElement.getElementsByClassName('fas')[0]
      if (icon.classList.contains('fa-check')) icon.classList.remove('fa-check')
      icon.classList.add('fa-times')
    }), {
    role: 'unmark'
  })
}