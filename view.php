<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 3.2//EN">
<HEAD>
    <TITLE>Chattr</TITLE>
</HEAD>
<BODY BGCOLOR=WHITE>
<TABLE ALIGN="CENTER">
<TR><TD>
<H1>Chattr</H1>
</TD></TR>

<?php
	// The following <TR> element should only appear if the user is
	// logged in and viewing his own entry.
    session_start();
    $username = $_SESSION['username'];
    if($username != null)
    {
?>
    <TR><TD>
    <FORM ACTION="post.php" METHOD="POST">
    <TABLE CELLPADDING=5>
    <TR><TD>Message:</TD><TD><INPUT TYPE="TEXT" NAME="TEXT">
    <INPUT TYPE="SUBMIT" VALUE="Submit"></TD></TR>
    </TABLE>
    </FORM>
    </TD></TR>
<?php 
    } 
?>  
<?php
	// The following <TR> element should always appear if the user
	// exists.
?>
<?php
    $host = "localhost";
    $user = "chattr";
    $pass = "toomanysecrets";
    $db = "chattr";
    $con = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass") or die ("Failed connection\n");
    $urlName = $_GET['user'];
    $stmt = "SELECT post_ref, posttime, message FROM post WHERE post_ref=$urlName";
    $query = pg_query($con, $stmt);

    // if true
    if(!$query)
    {
        while($row = pg_fetch_row($query))
        {
?>
    <TR><TD>
    <TABLE CELLPADDING=5>
    <TR><TH>When</TH><TH>Who</TH><TH>What</TH></TR>
<?php
		// Display user's posts here. The structure is:
		//
		//     <TR>
		//         <TD>DATE GOES HERE</TD>
		//         <TD>USER NAME GOES HERE</TD>
		//         <TD>MESSAGE TEXT GOES HERE</TD>
		//     </TR>
?>
    <TR>
        <TD><?php echo "$row[1]" ?></TD>
        <TD><?php echo "$row[3]" ?></TD>
        <TD><?php echo "$row[2]" ?></TD>
    </TR>

    </TABLE>
    </TD></TR>
<?php
        }
    }
?>
<?php
	// The following <TR> element should be displayed if the user
	// name does not exist. Add code to display user name.
    $query = pg_query($con, "SELECT username FROM poster WHERE username=$urlName");
    if(!$query)
    {
?>
    <TR><TD>
    <H2>User <?php echo "$urlName" ?> does not exist!</H2>
    </TD></TR>
<?php
    }
?>
<?php
	// The following <TR> element should only be shown if the user
	// is logged in.
?>
<?php 
    if($username != null)
    {
?>
<TR><TD><A HREF="logout.php">Logout</A></TR></TD>
<?php
	}// Done!
?>
</TABLE>
</BODY>

