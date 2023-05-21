if (document.URL.search("post-new") !== -1) {
  var restrict = document.querySelectorAll(
    ".pms-meta-box-field-wrapper label input[type='checkbox']"
  );
  restrict.forEach((element) => {
    element.checked = true;
  });
}
if (document.URL.search("edit") !== -1) {
  var epn = document.getElementById("episode_numbar");
  if (epn) {
    var last_ep = epn.value;
    var button = document.querySelector(
      ".add-group-row[data-selector='servers_repeat']"
    );
    let counter = document.createElement("input");
    counter.setAttribute("type", "number");
    counter.setAttribute("placeholder", "عدد الحلقات");
    counter.setAttribute("id", "episodeCount");

    let newrow = document.createElement("tr");
    newrow.setAttribute("class", "cmb-type-text");
    newrow.innerHTML = `
    <tr class="cmb-type-text cmb_id_episode_numbar">
    <th style="width:18%"><label for="episodeCount">اضافة حلقات</label></th>
    <td>
        <input type="text" class="regular-text" id="episodeCount" placeholder="عدد الحلقات">
    </td>
    <td>
        <input type="button" class="button" id="episodesAdd" value="أضف حلقات">
    </td>
    </tr>
    `;

    var direct_link = document.querySelector(".cmb_id_direct_link");
    direct_link.parentNode.insertBefore(newrow, direct_link.nextSibling);

    let newButton = document.getElementById("episodesAdd");

    // counter.parentNode.insertBefore(newButton, counter.nextSibling);
    button.style.display = "none";
    // button.addEventListener("click", addEpisode);
    newButton.addEventListener("click", handleAdd);
  }
}
async function addEpisode(elements) {
  setTimeout(() => {
    var lastElement = document.querySelector(
      "#servers_repeat .repeatable-grouping[data-iterator='" +
        (elements.length + 1) +
        "'] #servers_" +
        (elements.length + 1) +
        "_server_name"
    );
    var epn = document.getElementById("episode_numbar");
    var last_ep = parseInt(epn.value) + 1;
    lastElement.value = "الحلقة " + last_ep;

    epn.value = last_ep;
  }, 100);
}
async function handleAdd() {
  var counter = parseInt(document.querySelector("#episodeCount").value);
  var i = 1;
  while (i <= counter) {
    // console.log("called");
    var elements = document.querySelectorAll(
      "#servers_repeat .repeatable-grouping"
    );
    document
      .querySelector(".add-group-row[data-selector='servers_repeat']")
      .click();
    await addEpisode(elements);
    i = i + 1;
  }
}
