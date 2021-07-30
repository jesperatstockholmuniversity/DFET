(function(){
  "use strict";
  function isAnchorTag(element) {
    if (!element.innerHTML && element.nodeName == "A") {
      return true;
    }
    return false;
  }

  function findAnchorTags(tree) {
    var aTags = tree.getElementsByTagName('a');
    var finalATags = [];
    for (var i=0; i<aTags.length; i++) {
      console.log(aTags[i]);
      if (isAnchorTag(aTags[i])) {
        finalATags.push(aTags[i]);
      }
    }
    return finalATags;
  }

  function hasAnchorRootTag(element) {
    if (element.firstChild && isAnchorTag(element.firstChild)) {
      return true;
    }
    return false;
  }

  function findRootByClassName(element, className) {
    var parent = element.parentElement;
    while (parent.className != className) {
      if (parent.parentElement.className == className) {
        return parent;
      } else {
        parent = parent.parentElement;
      }
    }
    return false;
  }

  function getContentSectionId(tree, section) {
    var sectionId = -1;

    var aTags = findAnchorTags(tree);
    for (var i=0; i<aTags.length; i++) {

      var root = findRootByClassName(aTags[i], "media-body");
      if (hasAnchorRootTag(root)) {
        sectionId++;
      }

      if (aTags[i].id == section) {
        root.style.display = "";

        break;
      }
    }
    return sectionId;
  }

  function showSection(sectionName) {
    var tree = document.getElementById("courseDescription");
    var sectionId = getContentSectionId(tree, sectionName);

    // Hide all children of the tree but the chosen section
    var atSection = -1;
    for (var i=0; i<tree.children.length; i++) {
      var child = tree.children[i];
      
      if (hasAnchorRootTag(child)) {
        atSection++;
      }

      if (atSection != sectionId) {
        child.style.display = "none";
      } else {
        child.style.display = "";
      }
    }
  }

  function generateTableOfContents(tree, destination) {
    // Find the section that the user wants to access
    var sectionName = window.location.hash.substring(1);
    var sectionId = 0;
    if (sectionName != "") {
      sectionId = getContentSectionId(tree, sectionName);
    }

    // Hide all children of the tree but the chosen section
    var atSection = -1;
    for (var i=0; i<tree.children.length; i++) {
      var child = tree.children[i];
      
      if (hasAnchorRootTag(child)) {
        atSection++;
      }

      if (atSection != sectionId) {
        child.style.display = "none";
      }
    }

    var aTags = findAnchorTags(tree);
    var tocStructure = [];
    for (var i=0; i<aTags.length; i++) {
      var parent = findRootByClassName(aTags[i], "media-body");

      if (hasAnchorRootTag(parent)) {
        tocStructure.push(parent);
      }
    }

    var tocList = document.createElement("ul");

    aTags.forEach(function(aTag) {
      var listItem = document.createElement("li");
      var anchorTag = document.createElement("a");
      anchorTag.href = '#'+aTag.id;

      var root = findRootByClassName(aTag, "media-body");
      if (root.firstChild == aTag) {
        anchorTag.innerHTML = aTag.name;
      } else {
        anchorTag.innerHTML = " - " + aTag.name;
      }

      listItem.appendChild(anchorTag);

      var callback = function(evt) {
        showSection(aTag.name);
      };

      listItem.addEventListener('click', callback);

      tocList.appendChild(listItem);
    });

    destination.appendChild(tocList);

    return tocStructure;
  }

  docReady(function() {
    var tocStructure = generateTableOfContents(document.getElementById("courseDescription"), document.getElementById("courseTOC"));
  });
}());
