// This will be the global DATA object for passing data to the client
// from the server for initial binding.
DATA = {};

// This is the sign and submit object.
DATA.sns = {

    "profId": "Professor Neehra",
    "eSig": "pneehra01",
    "comment": "This is a comment.",
    "subType": "reg",
    "uniqueId": "1",
    "badSig": false
};

// Capture user data
DATA.user = {

    "role":"ai_admin",
    "firstName":"Tester"
};

// Capture professors from DB
DATA.profs = [

    {"name":"Atomic ","id":2168},
    {"name":"Kathleen Annala-Faculty","id":4},
    {"name":"Dean Cox","id":108},
    {"name":"David Kaplow","id":5},
    {"name":"Shad Neese","id":1},
    {"name":"Neehra Perfect","id":6},
    {"name":"Amber Vadnais","id":273},
    {"name":"Nate Woodard-Faculty","id":18850}
];

DATA.list = [
    {
        "uniqueId":1,
        "firstName":"Justin",
        "lastName":"Lowery",
        "suffix":"I",
        "dateOfBirth":"09\/06\/1974",
        "socialSecurity":"999999999"
    },
    {
        "uniqueId":2,
        "firstName":"Nina",
        "lastName":"Ozuna",
        "suffix":"I",
        "dateOfBirth":"02\/05\/1980",
        "socialSecurity":"999999998"
    }
];

DATA.query = '';

DATA.searchTerms = '';