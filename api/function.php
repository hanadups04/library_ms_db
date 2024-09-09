<?php

require '../inc/dbcon.php';

/*--BOOKS--*/
/*--Read Books List Starts Here--*/
function getBooksList(){

    global $conn;

    $query = "SELECT * FROM books_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Books List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Book Found',
            ];
            header("HTTP/1.0 404 No Book Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--Read Books List Ends Here--*/

/*--Single Read Books Starts Here--*/
function getBook($bookParams){

    global $conn;

    if($bookParams['book_id'] == null){

        return error422('Enter your book id');

    } 

    $book_id = mysqli_real_escape_string($conn, $bookParams['book_id']);

    $query = "SELECT * FROM books_tbl WHERE book_id='$book_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Book Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Book Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--Single Read Books Ends Here--*/

/*--Insert Book List Starts Here--*/
function insertBooks($bookInput){

    global $conn;

    $author_id = mysqli_real_escape_string($conn, $bookInput['author_id']);
    $publisher_id = mysqli_real_escape_string($conn, $bookInput['publisher_id']);
    $title = mysqli_real_escape_string($conn, $bookInput['title']);
    $genre = mysqli_real_escape_string($conn, $bookInput['genre']);
    $publication_year = mysqli_real_escape_string($conn, $bookInput['publication_year']);
    $num_of_copies = mysqli_real_escape_string($conn, $bookInput['num_of_copies']);
    $shelf_location = mysqli_real_escape_string($conn, $bookInput['shelf_location']);

    if(empty(trim($author_id))){

        return error422('Enter author_id');

    } elseif (empty(trim($publisher_id))) {

        return error422('Enter publisher id');
    
    } elseif (empty(trim($title))) {

        return error422('Enter book title');
    
    } elseif (empty(trim($genre))) {

        return error422('Enter book genre');
    
    } elseif (empty(trim($publication_year))) {

        return error422('Enter publication year');

    } elseif (empty(trim($num_of_copies))) {

        return error422('Enter number of copies');

    } elseif (empty(trim($shelf_location))) {

        return error422('Enter shelf location');

    } else {
        
        $query = "INSERT INTO books_tbl (author_id, publisher_id, title, genre, publication_year, num_of_copies,  shelf_location) 
        VALUES ('$author_id','$publisher_id','$title','$genre','$publication_year','$num_of_copies','$shelf_location')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Book Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Insert Book List Ends Here--*/

/*--Update Books List Starts Here--*/
function updateBooks($bookInput, $bookParams){

    global $conn;

    if(!isset($bookParams['book_id'])){

        return error422('Book id not found in URL');

    } elseif($bookParams['book_id'] == null){

        return error422('Enter the Book id');

    }

    $book_id = mysqli_real_escape_string($conn, $bookParams['book_id']);
    $author_id = mysqli_real_escape_string($conn, $bookInput['author_id']);
    $publisher_id = mysqli_real_escape_string($conn, $bookInput['publisher_id']);
    $title = mysqli_real_escape_string($conn, $bookInput['title']);
    $genre = mysqli_real_escape_string($conn, $bookInput['genre']);
    $publication_year = mysqli_real_escape_string($conn, $bookInput['publication_year']);
    $num_of_copies = mysqli_real_escape_string($conn, $bookInput['num_of_copies']);
    $shelf_location = mysqli_real_escape_string($conn, $bookInput['shelf_location']);

    if(empty(trim($author_id))){

        return error422('Enter author_id');

    } elseif (empty(trim($publisher_id))) {

        return error422('Enter publisher id');
    
    } elseif (empty(trim($title))) {

        return error422('Enter book title');
    
    } elseif (empty(trim($genre))) {

        return error422('Enter book genre');
    
    } elseif (empty(trim($publication_year))) {

        return error422('Enter publication year');

    } elseif (empty(trim($num_of_copies))) {

        return error422('Enter number of copies');

    } elseif (empty(trim($shelf_location))) {

        return error422('Enter shelf location');

    } else {

        $query = "UPDATE books_tbl SET author_id='$author_id', publisher_id='$publisher_id', title='$title', genre='$genre', publication_year='$publication_year',
        num_of_copies='$num_of_copies', shelf_location='$shelf_location' WHERE book_id ='$book_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Book Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Update Books List Ends Here--*/

/*--Delete Books List Starts Here--*/
function deleteBooks($bookParams){

    global $conn;

    if(!isset($bookParams['book_id'])){

        return error422('Book id not found in URL');

    } elseif($bookParams['book_id'] == null){

        return error422('Enter the Book id');

    }

    $book_id = mysqli_real_escape_string($conn, $bookParams['book_id']);

    $query = "DELETE FROM books_tbl WHERE book_id='$book_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Book Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--Delete Books List Ends Here--*/
/*--BOOKS--*/


/*--AUTHORS--*/
/*--Read Authors List Starts Here--*/
function getAuthorsList(){

    global $conn;

    $query = "SELECT * FROM authors_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Authors List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Author Found',
            ];
            header("HTTP/1.0 404 No Author Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--Read Authors List Ends Here--*/

/*--Single Read Authors Starts Here--*/
function getAuthor($authorParams){

    global $conn;

    if($authorParams['author_id'] == null){

        return error422('Enter your author id');

    } 

    $author_id = mysqli_real_escape_string($conn, $authorParams['author_id']);

    $query = "SELECT * FROM authors_tbl WHERE author_id='$author_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Author Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Author Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--Single Read Authors Ends Here--*/

/*--Insert Authors List Starts Here--*/
function error422($message){

    $data = [
        'status' => 422,
        'message' => $message, 
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function insertAuthors($authorInput){

    global $conn;

    $first_name = mysqli_real_escape_string($conn, $authorInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $authorInput['last_name']);

    if(empty(trim($first_name))){

        return error422('Enter your first name');

    } elseif (empty(trim($last_name))) {

        return error422('Enter your last name');

    } else {

        $query = "INSERT INTO authors_tbl (first_name, last_name) VALUES ('$first_name','$last_name')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Author Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Insert Authors List Ends Here--*/

/*--Update Authors List Starts Here--*/
function updateAuthors($authorInput, $authorParams){

    global $conn;

    if(!isset($authorParams['author_id'])){

        return error422('Author id not found in URL');

    } elseif($authorParams['author_id'] == null){

        return error422('Enter the Author id');

    }

    $author_id = mysqli_real_escape_string($conn, $authorParams['author_id']);
    $first_name = mysqli_real_escape_string($conn, $authorInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $authorInput['last_name']);

    if(empty(trim($first_name))){

        return error422('Enter your first name');

    } elseif (empty(trim($last_name))) {

        return error422('Enter your last name');

    } else {

        $query = "UPDATE authors_tbl SET first_name='$first_name', last_name='$last_name' WHERE author_id ='$author_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Author Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Update Authors List Ends Here--*/

/*--Delete Authors List Starts Here--*/
function deleteAuthors($authorParams){

    global $conn;

    if(!isset($authorParams['author_id'])){

        return error422('Author id not found in URL');

    } elseif($authorParams['author_id'] == null){

        return error422('Enter the Author id');

    }

    $author_id = mysqli_real_escape_string($conn, $authorParams['author_id']);

    $query = "DELETE FROM authors_tbl WHERE author_id='$author_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Author Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Author Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--Delete Authors List Ends Here--*/
/*--AUTHORS--*/


/*--PUBLISHERS--*/
/*--Read Publishers List Starts Here--*/
function getPublishersList(){

    global $conn;

    $query = "SELECT * FROM publisher_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Publishers List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Publisher Found',
            ];
            header("HTTP/1.0 404 No Publisher Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--Read Publishers List Ends Here--*/

/*--Single Read Publishers Starts Here--*/
function getPublisher($publisherParams){

    global $conn;

    if($publisherParams['publisher_id'] == null){

        return error422('Enter your publisher id');

    } 

    $publisher_id = mysqli_real_escape_string($conn, $publisherParams['publisher_id']);

    $query = "SELECT * FROM publisher_tbl WHERE publisher_id='$publisher_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Publisher Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Publisher Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--Single Read Publishers Ends Here--*/

/*--Insert Publishers List Starts Here--*/
function insertPublishers($publisherInput){

    global $conn;

    $publisher_name = mysqli_real_escape_string($conn, $publisherInput['publisher_name']);
    $address = mysqli_real_escape_string($conn, $publisherInput['address']);
    $contact_number = mysqli_real_escape_string($conn, $publisherInput['contact_number']);
    $email = mysqli_real_escape_string($conn, $publisherInput['email']);
    $website = mysqli_real_escape_string($conn, $publisherInput['website']);

    if(empty(trim($publisher_name))){

        return error422('Enter your publisher name');

    } elseif (empty(trim($address))) {

        return error422('Enter your address');

    } elseif (empty(trim($contact_number))) {

        return error422('Enter your contact number');

    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($website))) {

        return error422('Enter your website');

    } else {
        
        $query = "INSERT INTO publisher_tbl (publisher_name, address, contact_number, email, website) 
        VALUES ('$publisher_name','$address','$contact_number','$email','$website')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Publisher Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Insert Publishers List Ends Here--*/

/*--Update Publishers List Starts Here--*/
function updatePublishers($publisherInput, $publisherParams){

    global $conn;

    if(!isset($publisherParams['publisher_id'])){

        return error422('Publisher id not found in URL');

    } elseif($publisherParams['publisher_id'] == null){

        return error422('Enter the Publisher id');

    }

    $publisher_id = mysqli_real_escape_string($conn, $publisherParams['publisher_id']);
    $publisher_name = mysqli_real_escape_string($conn, $publisherInput['publisher_name']);
    $address = mysqli_real_escape_string($conn, $publisherInput['address']);
    $contact_number = mysqli_real_escape_string($conn, $publisherInput['contact_number']);
    $email = mysqli_real_escape_string($conn, $publisherInput['email']);
    $website = mysqli_real_escape_string($conn, $publisherInput['website']);

    if(empty(trim($publisher_name))){

        return error422('Enter your publisher name');

    } elseif (empty(trim($address))) {

        return error422('Enter your address');

    } elseif (empty(trim($contact_number))) {

        return error422('Enter your contact number');

    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($website))) {

        return error422('Enter your website');

    } else {

        $query = "UPDATE publisher_tbl SET publisher_name='$publisher_name', address='$address', contact_number='$contact_number', email='$email', website='$website' 
        WHERE publisher_id ='$publisher_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Publisher Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Update Publishers List Ends Here--*/

/*--Delete Publishers List Starts Here--*/
function deletePublishers($publisherParams){

    global $conn;

    if(!isset($publisherParams['publisher_id'])){

        return error422('Publisher id not found in URL');

    } elseif($publisherParams['publisher_id'] == null){

        return error422('Enter the Publisher id');

    }

    $publisher_id = mysqli_real_escape_string($conn, $publisherParams['publisher_id']);

    $query = "DELETE FROM publisher_tbl WHERE publisher_id='$publisher_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Publisher Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--Delete Publishers List Ends Here--*/
/*--PUBLISHERS--*/ 


/*--LIBRARY MEMBERS--*/
/*--Read Library Members List Starts Here--*/
function getMembersList(){

    global $conn;

    $query = "SELECT * FROM library_members_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Members List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Member Found',
            ];
            header("HTTP/1.0 404 No Member Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--Read Library Members List Ends Here--*/

/*--Single Read Members Starts Here--*/
function getMember($memberParams){

    global $conn;

    if($memberParams['member_id'] == null){

        return error422('Enter your member id');

    } 

    $member_id = mysqli_real_escape_string($conn, $memberParams['member_id']);

    $query = "SELECT * FROM library_members_tbl WHERE member_id='$member_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Member Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Member Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--Single Read Members Ends Here--*/

/*--Insert Members List Starts Here--*/
function insertMembers($memberInput){

    global $conn;

    $first_name = mysqli_real_escape_string($conn, $memberInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $memberInput['last_name']);
    $email = mysqli_real_escape_string($conn, $memberInput['email']);
    $contact_number = mysqli_real_escape_string($conn, $memberInput['contact_number']);
    $dob = mysqli_real_escape_string($conn, $memberInput['dob']);
    $address = mysqli_real_escape_string($conn, $memberInput['address']);
    $membership_start = date('Y-m-d');
    $membership_end = date('Y-m-d', strtotime('+30 days'));

    if(empty(trim($first_name))){

        return error422('Enter your first name');

    } elseif (empty(trim($last_name))) {

        return error422('Enter your last name');
    
    } elseif (empty(trim($email))) {

        return error422('Enter your email');
    
    } elseif (empty(trim($contact_number))) {

        return error422('Enter your contact number');
    
    } elseif (empty(trim($dob))) {

        return error422('Enter your date of birth');

    } elseif (empty(trim($address))) {

        return error422('Enter your address');

    } elseif (empty(trim($membership_start))) {

        return error422('Enter your membership start');

    } elseif (empty(trim($membership_end))) {

        return error422('Enter your membership end');

    } else {
        
        $query = "INSERT INTO library_members_tbl (first_name, last_name, email, contact_number, dob, address,  membership_start, membership_end) 
        VALUES ('$first_name','$last_name','$email','$contact_number','$dob','$address','$membership_start','$membership_end')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Member Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Insert Members List Ends Here--*/

/*--Update Members List Starts Here--*/
function updateMembers($memberInput, $memberParams){

    global $conn;

    if(!isset($memberParams['member_id'])){

        return error422('Member id not found in URL');

    } elseif($memberParams['member_id'] == null){

        return error422('Enter the Member id');

    }

    $member_id = mysqli_real_escape_string($conn, $memberParams['member_id']);
    $first_name = mysqli_real_escape_string($conn, $memberInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $memberInput['last_name']);
    $email = mysqli_real_escape_string($conn, $memberInput['email']);
    $contact_number = mysqli_real_escape_string($conn, $memberInput['contact_number']);
    $dob = mysqli_real_escape_string($conn, $memberInput['dob']);
    $address = mysqli_real_escape_string($conn, $memberInput['address']);
    $membership_start = mysqli_real_escape_string($conn, $memberInput['membership_start']);
    $membership_end = mysqli_real_escape_string($conn, $memberInput['membership_end']);

    if(empty(trim($first_name))){

        return error422('Enter your first name');

    } elseif (empty(trim($last_name))) {

        return error422('Enter your last name');
    
    } elseif (empty(trim($email))) {

        return error422('Enter your email');
    
    } elseif (empty(trim($contact_number))) {

        return error422('Enter your contact number');
    
    } elseif (empty(trim($dob))) {

        return error422('Enter your date of birth');

    } elseif (empty(trim($address))) {

        return error422('Enter your address');

    } elseif (empty(trim($membership_start))) {

        return error422('Enter your membership start');

    } elseif (empty(trim($membership_end))) {

        return error422('Enter your membership end');

    } else {

        $query = "UPDATE library_members_tbl SET first_name='$first_name', last_name='$last_name', email='$email', contact_number='$contact_number', dob='$dob',
        address='$address', membership_start='$membership_start', membership_end='$membership_end' WHERE member_id ='$member_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Member Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Update Members List Ends Here--*/

/*--Delete Members List Starts Here--*/
function deleteMembers($memberParams){

    global $conn;

    if(!isset($memberParams['member_id'])){

        return error422('Member id not found in URL');

    } elseif($memberParams['member_id'] == null){

        return error422('Enter the Member id');

    }

    $member_id = mysqli_real_escape_string($conn, $memberParams['member_id']);

    $query = "DELETE FROM library_members_tbl WHERE member_id='$member_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Member Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--Delete Members List Ends Here--*/
/*--LIBRARY MEMBERS--*/


/*--BOOKS BORROWED--*/
/*--Read Books Borrowed List Starts Here--*/
function getBooksBorrowedList(){

    global $conn;

    $query = "SELECT * FROM booksBorrowed_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Books Borrowed List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Books Borrowed Found',
            ];
            header("HTTP/1.0 404 No Books Borrowed Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--Read Books Borrowed List Ends Here--*/

/*--Single Read Books Borrowed  Starts Here--*/
function getBookBorrowed($bookBorrowedParams){

    global $conn;

    if($bookBorrowedParams['borrow_id'] == null){

        return error422('Enter your borrow id');

    } 

    $borrow_id = mysqli_real_escape_string($conn, $bookBorrowedParams['borrow_id']);

    $query = "SELECT * FROM booksborrowed_tbl WHERE borrow_id='$borrow_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Book Borrowed Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Book Borrowed Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--Single Read Books Borrowed  Ends Here--*/

/*--Insert Books Borrowed Starts Here--*/
function insertBooksBorrowed($bookBorrowedInput){

    global $conn;

    $book_id = mysqli_real_escape_string($conn, $bookBorrowedInput['book_id']);
    $member_id = mysqli_real_escape_string($conn, $bookBorrowedInput['member_id']);
    $borrow_date = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime('+30 days'));
    $status = mysqli_real_escape_string($conn, $bookBorrowedInput['status']);

    if(empty(trim($book_id))){

        return error422('Enter book id');

    } elseif (empty(trim($member_id))) {

        return error422('Enter member id');
    
    } elseif (empty(trim($borrow_date))) {

        return error422('Enter borrow date');
    
    } elseif (empty(trim($due_date))) {

        return error422('Enter book genre');
    
    }  elseif (empty(trim($status))) {

        return error422('Enter status');

    } else {
        
        $query = "INSERT INTO booksborrowed_tbl (book_id, member_id, borrow_date, due_date, status) 
        VALUES ('$book_id','$member_id','$borrow_date','$due_date','$status')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Book Borrowed Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Insert Books Borrowed  Ends Here--*/

/*--Update Books Borrowed  Starts Here--*/
function updateBookBorrowed($bookBorrowedInput, $bookBorrowedParams){

    global $conn;

    if(!isset($bookBorrowedParams['borrow_id'])){

        return error422('Borrow id not found in URL');

    } elseif($bookBorrowedParams['borrow_id'] == null){

        return error422('Enter the Borrow id');

    }

    $borrow_id = mysqli_real_escape_string($conn, $bookBorrowedParams['borrow_id']);
    $book_id = mysqli_real_escape_string($conn, $bookBorrowedInput['book_id']);
    $member_id = mysqli_real_escape_string($conn, $bookBorrowedInput['member_id']);
    $borrow_date = mysqli_real_escape_string($conn, $bookBorrowedInput['borrow_date']);
    $due_date = mysqli_real_escape_string($conn, $bookBorrowedInput['due_date']);
    $return_date = mysqli_real_escape_string($conn, $bookBorrowedInput['return_date']);
    $status = mysqli_real_escape_string($conn, $bookBorrowedInput['status']);

    if(empty(trim($book_id))){

        return error422('Enter book id');

    } elseif (empty(trim($member_id))) {

        return error422('Enter member id');
    
    } elseif (empty(trim($borrow_date))) {

        return error422('Enter borrow date');
    
    } elseif (empty(trim($due_date))) {

        return error422('Enter due date');
    
    } elseif (empty(trim($return_date))) {

        return error422('Enter return date');

    } elseif (empty(trim($status))) {

        return error422('Enter status');

    } else {

        $query = "UPDATE booksborrowed_tbl SET book_id='$book_id', member_id='$member_id', borrow_date='$borrow_date', due_date='$due_date', return_date='$return_date',
        status='$status' WHERE borrow_id ='$borrow_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Book Borrowed Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--Update Books Borrowed  Ends Here--*/

/*--Delete Books Borrowed Starts Here--*/
function deleteBookBorrowed($bookBorrowedParams){

    global $conn;

    if(!isset($bookBorrowedParams['borrow_id'])){

        return error422('Borrow id not found in URL');

    } elseif($bookBorrowedParams['borrow_id'] == null){

        return error422('Enter the Borrow id');

    }

    $borrow_id = mysqli_real_escape_string($conn, $bookBorrowedParams['borrow_id']);

    $query = "DELETE FROM booksborrowed_tbl WHERE borrow_id='$borrow_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Book Borrowed Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--Delete Books Borrowed Ends Here--*/
/*--BOOKS BORROWED--*/
?>



