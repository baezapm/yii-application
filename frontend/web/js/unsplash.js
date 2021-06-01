
console.log(collections);

function search() {
    const search = $("#search").val();

    if (!search) {
        return alert("Search no can't be empty");
    }

    const url = `/unsplash/search`;
    $.ajax({
        url,
        type: "POST",
        data: { search },
        success: function (data) {
            let strToRender = "<p>No results</p>";

            if (data.data.results.length > 0) {
                let description;
                strToRender = "";

                data.data.results.forEach(photo => {
                    description = photo.description || photo.alt_description;
                    strToRender += buildBox(photo.urls.small, description, photo.id);
                });
            }

            $("#gallery").html(strToRender);
        }
    });
}

function addFavorites(photo_unsplash_id, collection_id, path) {
    const url = `/photo/add`;
    $.ajax({
        url,
        type: "GET",
        data: {
          photo_unsplash_id,
          collection_id,
          path
        },
        success: function (data) {
            alert(data.message);
        }
    });
}

function buildBox(url, description, photoId) {
    strCollectionsOp = collections.map(
        collection => `<button class="dropdown-item"
        onclick="addFavorites('${photoId}', ${collection.id}, '${url}')">${collection.name}</button>`
    ).join("");

    return `<div class="box-photo">` +
        `<a target="_blank" href="${url}">` +
        `<img src="${url}" alt="photo" width="600" height="400">` +
        `</a>` +
        `<div class="description">${description}</div>` +
        `<div class="dropdown">` +
        `<button class="btn btn-primary " type="button" id="dropdownCollections" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">` +
        `Add Collection` +
        `</button>` +
        `<div class="dropdown-menu" aria-labelledby="dropdownCollections">` +
        strCollectionsOp +
        `</div>` +
        `</div>` +
        `</div>`;
}
