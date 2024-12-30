/** 
 * Class to create Objects to control the table records in Credits and Events 
 * @param {NodeListOf<HTMLInputElement>} checkBoxes
 * @param {string} tableID
 * @param {HTMLTableElement} table
 * */

class TableRecords {

  /**
   * constructor - Create an instance of TableRecords by passing the table ID
   * @param {string} tableID
   */
  
  constructor(tableID) {
    this.tableID = tableID
    this.table = document.getElementById(tableID)

    /** @type {NodeListOf<HTMLInputElement>} */
    this.checkBoxes = this.table.querySelectorAll('input[type="checkbox"]');
    console.log(this.checkBoxes)
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
}