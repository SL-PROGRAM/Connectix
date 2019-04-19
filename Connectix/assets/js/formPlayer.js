const $ = require('jquery');


var $collectionHolderUser;
var $addUserButton = $('<div><button type="button" class="add_User_link btn">Add a User</button></div>');
var $newLinkLiUser = $('<li></li>').append($addUserButton);
//

jQuery(document).ready(function() {

    $collectionHolderUser = $('ul.users');
    $collectionHolderUser.find('li').each(function() {
        addUserFormDeleteLink($(this));
    });
    $collectionHolderUser.append($newLinkLiUser);
    $collectionHolderUser.data('userIndex', $collectionHolderUser.find(':input').length);

    $addUserButton.on('click', function(e) {
        // add a new Socity form (see next code block)
        addUserForm($collectionHolderUser, $newLinkLiUser);
    });

});

function addUserForm($collectionHolderUser, $newLinkLiUser) {
    // Get the data-prototype explained earlier
    var userPrototype = $collectionHolderUser.data('prototype-user');

    // get the new index
    var index = $collectionHolderUser.data('userIndex');

    var newForm = userPrototype;
    // You need this only if you didn't set 'label' => false in your Socitys field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/player/g, index);
    console.log(newForm);


    // increase the index with one for the next item
    $collectionHolderUser.data('userIndex', index + 1);

    // Display the form in the page in an li, before the "Add a Socity" link li
    var $newUserFormLi = $('<li><h3>User</h3></li>').append(newForm);
    $newUserFormLi.append($addUserButton);

    $newLinkLiUser.before($newUserFormLi);
    addUserFormDeleteLink($newUserFormLi);
}

function addUserFormDeleteLink($userFormLi) {
    var $removeFormButton = $('<button type="button" class="btn">Delete this user</button>');
    $userFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $userFormLi.remove();
    });
}

