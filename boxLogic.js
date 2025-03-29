let boxes = document.getElementsByClassName('dropBox');

// Enable drag-and-drop + touch support
function itemDraggable() {
    this.addEventListener('dragstart', handleDragStart);
    this.addEventListener('touchstart', handleTouchStart, { passive: false });
}
let selected = null;
function handleDragStart(e) {
    if (e.target.tagName === "INPUT" || e.target.tagName === "IMG") return;

    selected = e.target;

    for (let box of boxes) {
        box.addEventListener('dragover', function (e) {
            e.preventDefault();
        });

        box.addEventListener('drop', function () {
            try {
                if (selected instanceof Node) {
                    box.appendChild(selected);

                    let box_id = box.getAttribute('boxID');
                    let content = selected.childNodes[0].value;
                    AddDataPOST(box_id, content);
                }
            }
            catch (error) {
                console.error("Error appending element:", error);
            }
            finally {
                selected = null;
            }
        });
    }
}

// Handle touch drag start (for mobile)
function handleTouchStart(e) {
    if (e.target.tagName === "INPUT") return;

    if (e.target.tagName === "IMG") {
        this.remove();
        return;
    }

    e.preventDefault(); // Prevent scrolling
    let selected = e.target.closest('.list_item');
    if (!selected) return;

    let touch = e.touches[0];

    let rect = selected.getBoundingClientRect();
    offsetX = touch.pageX - rect.left;
    offsetY = touch.pageY - rect.top;

    selected.style.zIndex = "1000";
    selected.style.width = `${selected.offsetWidth}px`; // Prevent resizing while moving

    function moveAt(touch) {
        selected.style.left = (touch.pageX - offsetX) + "px";
        selected.style.top = (touch.pageY - offsetY) + "px";
    }

    moveAt(touch);

    function handleTouchMove(e) {
        e.preventDefault(); // Stop scrolling while dragging
        moveAt(e.touches[0]);
    }

    function handleTouchEnd(e) {
        let dropTarget = document.elementFromPoint(e.changedTouches[0].clientX, e.changedTouches[0].clientY);

        // Find the closest dropBox
        for (let box of boxes) {
            if (box.contains(dropTarget) || box === dropTarget) {
                try {
                    box.appendChild(selected);

                    let cont = seleted.closest("input").value;
                    if (cont !== "") {
                        let box_id = box.getAttribute("boxID");
                        AddDataPOST(box_id, cont);
                    }
                }
                catch { }
                break;
            }
        }

        selected.style.position = "relative";
        selected.style.zIndex = "auto";
        selected.style.left = "auto";
        selected.style.top = "auto";

        document.removeEventListener('touchmove', handleTouchMove);
        document.removeEventListener('touchend', handleTouchEnd);
    }

    document.addEventListener('touchmove', handleTouchMove, { passive: false });
    document.addEventListener('touchend', handleTouchEnd);
}

function addItem(box = boxes[0], value = '') {
    function removeMe() {
        let box_id = this.closest(".dropBox").getAttribute('boxID');
        let content = item_input.value;
        if (content) {
            DeleteDataPOST(box_id, content);
        }

        this.closest('div').remove();
    }

    let item = document.createElement('div');
    item.className = 'list_item';
    item.draggable = 'true';

    let item_input = document.createElement('input');
    item_input.setAttribute('type', 'text');
    item_input.setAttribute('placeholder', 'Type here..');
    item_input.value = value;

    let item_b = document.createElement('button');
    item_b.type = 'button';
    item_b.className = 'delButt';
    item_b.innerHTML = '<img alt="" src="bin.svg" draggable="false">';
    item_b.addEventListener('click', removeMe);

    item.appendChild(item_input);
    item.appendChild(item_b);
    box.appendChild(item);

    // Make new item draggable
    itemDraggable.call(item);
}

// Attach event listeners to all existing draggable items
document.addEventListener("DOMContentLoaded", () => {
    for (let box of boxes) {
        let items = box.getElementsByClassName('list_item');
        for (let item of items) {
            itemDraggable.call(item);
        }
    }
});


function AddDataPOST(_box_id, _content) {
    let data = {
        action: "addContent",
        box_id: _box_id,
        content: _content
    };

    fetch("db.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then(response => response.text()) // or .json() if PHP returns JSON
        .then(data => console.log("Response:", data))
        .catch(error => console.error("Error:", error));
}

function DeleteDataPOST(_box_id, _content) {
    let data = {
        action: "deleteContent",
        box_id: _box_id,
        content: _content
    };

    fetch("db.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then(response => response.text()) // or .json() if PHP returns JSON
        .then(data => console.log("Response:", data))
        .catch(error => console.error("Error:", error));
}
