/** 
 * Class to create Objects to control the table records in Credits and Events 
 * @param {NodeListOf<HTMLInputElement>} checkBoxes
 * @param {string} tableID
 * @param {HTMLTableElement} table
 * @param {string} deleteLink
 * */

export default class TableRecords {


  deleteLink = 'delete_records.php';

  /**
   * constructor - Create an instance of TableRecords by passing the table ID
   * @param {string} tableID
   */

  constructor(tableID) {
    this.tableID = tableID
    this.table = document.getElementById(tableID)

    /** @type {NodeListOf<HTMLInputElement>} */
    this.checkBoxes = this.table.querySelectorAll('input[type="checkbox"]');
    // console.log(this.checkBoxes)
  }

  get isAllChecked() {
    return this.#checkedRecords.length === this.checkBoxes.length
  }

  get isAnythingChecked() {
    return this.#checkedRecords.length > 0
  }

  checkAllRecords() {
    this.checkBoxes.forEach(checkbox => (checkbox.checked) ? null : checkbox.click());
  }

  deCheckAllRecords() {
    this.#checkedRecords.forEach(checkbox => checkbox.click());
  }

  async deleteRecords() {
    const form = new FormData(this.#checkedRecords[0].form)
    form.append('record', this.tableID)

    const res = await fetch(`/api/${this.deleteLink}`, {
      method: 'POST',
      body: form,
    })

    const data = await res.json()

    if (res.ok && data.status == 1) this.#deleteRecordsUI()
  }

  #deleteRecordsUI() {
    this.#checkedRecords.forEach(checkbox => {
      const trEl = checkbox.parentElement.parentElement
      trEl.remove()
    })
  }

  toggleCheckedFilter() {
    this.isCheckedFilterOn = !this.isCheckedFilterOn
    const display = this.isCheckedFilterOn ? 'none' : 'block'
    this.#controlDisplayOfUncheckedRecords(display)
  }


  /**
   * @param {string} display
   */
  #controlDisplayOfUncheckedRecords(display) {
    this.checkBoxes.forEach(checkbox => {
      if (checkbox.checked) return
      const trEl = checkbox.parentElement.parentElement
      trEl.style.display = display
    })
  }

  /** @returns {NodeListOf<HTMLInputElement>} */
  get #checkedRecords() {
    return this.table.querySelectorAll('input[type="checkbox"]:checked')
  }

  setupEvents(eventTargets) {
    if (eventTargets.selectAllBtn)
      eventTargets.selectAllBtn.addEventListener('click', e => this.checkAllRecords()) // select all button 

    if (eventTargets.deSelectAllBtn)
      eventTargets.deSelectAllBtn.addEventListener('click', e => this.deCheckAllRecords()) //  deselect all button

    if (eventTargets.deleteBtn)
      eventTargets.deleteBtn.addEventListener('click', e => this.deleteRecords()) // delete button 

    this.table.addEventListener('change', e => {
      if(eventTargets.submitBtn)
      eventTargets.submitBtn.disabled = !this.isAnythingChecked

      if(eventTargets.deleteBtn)
      eventTargets.deleteBtn.disabled = !this.isAnythingChecked
    })
  }
}