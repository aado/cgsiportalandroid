<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= ($page['title'] ?? 'Undefined'); ?></h1>
	<div class="leave"  style="margin-top: 20px"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Underconstruction</div>
</div>
<?php
// $string = "
// 23-01-09-24-12-07	|
// 12-16-08-11-01-18	|
// 32-41-15-25-18-22	|
// 35-28-25-36-31-03	|
// 18-15-33-27-07-14	|
// 18-28-16-32-29-10	|
// 23-16-30-36-19-38	|
// 15-05-17-07-20-33	|
// 08-09-15-36-35-34	|
// 24-26-06-39-20-35	|
// 03-27-36-28-12-08	|
// 33-27-19-35-42-14	|
// 20-15-04-34-06-18	|
// 32-17-18-24-30-33	|
// 30-20-15-09-23-22	|
// 08-28-18-23-19-39	|
// 38-26-13-37-15-39	|
// 07-24-25-12-15-32	|
// 23-05-37-04-26-41	|
// 02-01-39-14-38-24	|
// 37-29-31-30-21-17	|
// 13-03-06-30-21-19	|
// 12-29-15-03-06-20	|
// 02-16-28-10-37-15	|
// 42-18-16-14-24-11	|
// 10-28-31-30-33-40	|
// 18-34-33-39-11-36	|
// 36-32-42-15-28-12	|
// 10-18-35-28-22-13	|
// 25-24-18-03-41-19	|
// 30-18-40-32-06-14	|
// 22-05-20-01-25-07	|
// 17-18-19-20-08-33	|
// 34-36-07-41-40-17	|
// 30-42-23-36-37-07	|
// 25-41-35-39-14-26	|
// 35-37-08-26-04-20	|
// 27-17-19-16-33-36	|
// 16-38-19-18-25-34	|
// 31-22-37-04-34-05	|
// 42-36-27-25-33-22	|
// 16-27-09-31-07-14	|
// 04-26-28-02-05-03	|
// 10-11-08-30-29-26	|
// 29-35-12-36-07-03	|
// 21-37-28-22-39-02	|
// 18-15-17-24-33-10	|
// 39-24-33-06-42-25	|
// 17-25-21-33-39-04	|
// 07-22-19-20-40-10	|
// 19-07-04-41-23-09	|
// 14-24-08-16-22-37	|
// 07-13-18-02-28-37	|
// 15-20-33-37-10-02	|
// 19-25-18-33-10-31	|
// 13-08-15-33-37-22	|
// 24-40-18-03-08-34	|
// 37-34-32-35-08-36	|
// 13-29-26-11-12-34	|
// 34-41-04-29-19-18	|
// 09-17-23-11-13-30	|
// 25-20-29-07-21-02	|
// 28-36-14-37-13-03	|
// 24-35-04-07-22-02	|
// 22-09-38-36-42-13	|
// 39-33-18-01-24-36	|
// 02-20-34-40-27-22	|
// 42-38-21-06-01-41	|
// 33-31-13-41-25-18	|
// 08-15-11-23-36-33	|
// 07-18-12-17-06-14	|
// 24-05-13-39-06-40	|
// 27-24-40-14-39-04	|
// 18-31-26-08-23-29	|
// 31-38-13-20-14-18	|
// 17-10-15-09-35-01	|
// 06-18-17-11-31-29	|
// 09-10-42-08-13-41	|
// 27-18-26-13-02-03	|
// 09-33-35-12-31-08	|
// 13-08-42-03-02-15	|
// 41-32-31-04-08-38	|
// 18-09-16-12-36-14	|
// 40-19-16-07-10-21	|
// 17-11-23-21-05-25	|
// 24-30-32-37-02-05	|
// 37-22-25-08-26-15	|
// 14-33-32-11-12-15	|
// 01-14-26-29-27-18	|
// 29-32-12-23-01-21	|
// 04-31-37-20-05-39	|
// 42-19-15-40-03-33	|
// 42-18-26-35-02-19	|
// 26-12-20-24-39-41	|
// 13-19-12-05-08-25	|
// 25-33-12-07-05-18	|
// 35-01-34-18-28-31	|
// 36-14-28-12-23-33	|
// 01-42-40-20-25-16	|
// 21-25-33-32-18-23	|
// 27-33-22-11-25-38	|
// 15-36-07-10-18-06	|
// 40-42-03-41-19-14	|
// 04-36-13-42-30-21	|
// 27-41-31-35-33-36	|
// 31-11-02-23-19-34	|
// 40-15-35-20-28-23	|
// 32-23-41-04-25-21	|
// 10-09-03-30-38-32	|
// 10-09-03-30-38-32	|
// 31-27-17-21-18-09	|
// 17-23-35-18-24-19	|
// 14-05-27-15-24-13	|
// 32-22-19-20-11-27	|
// 26-40-37-38-34-17	|
// 37-42-14-09-13-04	|
// 40-38-35-32-29-06	|
// 10-09-14-16-28-39	|
// 39-42-23-33-32-12	|
// 02-08-23-40-21-06	|
// 20-39-06-19-35-31	|
// 31-20-17-19-09-29	|
// 42-35-04-27-05-37	|
// 33-01-02-22-19-25	|
// 34-20-31-39-22-03	|
// 28-10-30-08-01-16	|
// 01-03-09-24-19-40	|
// 23-13-31-37-02-25	|
// 07-36-09-37-39-08	|
// 10-21-28-33-13-05	|
// 31-32-08-25-29-14	|
// 09-06-29-07-05-19	|
// 32-31-15-41-17-40	|
// 02-01-25-32-16-30	|
// 04-28-36-16-40-13	|
// 01-33-03-37-02-13	|
// 34-14-29-19-28-36	|
// 05-26-32-08-13-09	|
// 40-36-30-33-27-25	|
// 14-42-28-20-37-26	|
// 15-37-19-38-16-18	|
// 24-03-18-20-28-04	|
// 19-32-22-34-10-09	|
// 08-19-29-25-02-41	|
// 11-39-10-09-22-29	|
// 15-07-28-16-13-04	|
// 03-33-34-02-30-31	|
// 18-28-01-27-21-29	|
// 03-17-38-23-41-04	|
// 42-13-09-15-24-32	|
// 08-41-33-16-05-19	|
// 42-17-04-40-08-09	|
// 37-16-26-03-42-10	|
// 27-05-26-31-19-09	|
// 01-21-27-03-07-17	|";

// $str1 = explode('|', $string, );
// foreach ($str1 as $item) {
// 	echo explode('-',$item)[3].'<br>';
// }
// $stuff = array(
// 	'	24	'	,
// '	11	'	,
// '	25	'	,
// '	36	'	,
// '	27	'	,
// '	32	'	,
// '	36	'	,
// '	7	'	,
// '	36	'	,
// '	39	'	,
// '	28	'	,
// '	35	'	,
// '	34	'	,
// '	24	'	,
// '	9	'	,
// '	23	'	,
// '	37	'	,
// '	12	'	,
// '	4	'	,
// '	14	'	,
// '	30	'	,
// '	30	'	,
// '	3	'	,
// '	10	'	,
// '	14	'	,
// '	30	'	,
// '	39	'	,
// '	15	'	,
// '	28	'	,
// '	3	'	,
// '	32	'	,
// '	1	'	,
// '	20	'	,
// '	41	'	,
// '	36	'	,
// '	39	'	,
// '	26	'	,
// '	16	'	,
// '	18	'	,
// '	4	'	,
// '	25	'	,
// '	31	'	,
// '	2	'	,
// '	30	'	,
// '	36	'	,
// '	22	'	,
// '	24	'	,
// '	6	'	,
// '	33	'	,
// '	20	'	,
// '	41	'	,
// '	16	'	,
// '	2	'	,
// '	37	'	,
// '	33	'	,
// '	33	'	,
// '	3	'	,
// '	35	'	,
// '	11	'	,
// '	29	'	,
// '	11	'	,
// '	7	'	,
// '	37	'	,
// '	7	'	,
// '	36	'	,
// '	1	'	,
// '	40	'	,
// '	6	'	,
// '	41	'	,
// '	23	'	,
// '	17	'	,
// '	39	'	,
// '	14	'	,
// '	8	'	,
// '	20	'	,
// '	9	'	,
// '	11	'	,
// '	8	'	,
// '	13	'	,
// '	12	'	,
// '	3	'	,
// '	4	'	,
// '	12	'	,
// '	7	'	,
// '	21	'	,
// '	37	'	,
// '	8	'	,
// '	11	'	,
// '	29	'	,
// '	23	'	,
// '	20	'	,
// '	40	'	,
// '	35	'	,
// '	24	'	,
// '	5	'	,
// '	7	'	,
// '	18	'	,
// '	12	'	,
// '	20	'	,
// '	32	'	,
// '	11	'	,
// '	10	'	,
// '	41	'	,
// '	42	'	,
// '	35	'	,
// '	23	'	,
// '	20	'	,
// '	4	'	,
// '	30	'	,
// '	30	'	,
// '	21	'	,
// '	18	'	,
// '	15	'	,
// '	20	'	,
// '	38	'	,
// '	9	'	,
// '	32	'	,
// '	16	'	,
// '	33	'	,
// '	40	'	,
// '	19	'	,
// '	19	'	,
// '	27	'	,
// '	22	'	,
// '	39	'	,
// '	8	'	,
// '	24	'	,
// '	37	'	,
// '	37	'	,
// '	33	'	,
// '	25	'	,
// '	7	'	,
// '	41	'	,
// '	32	'	,
// '	16	'	,
// '	37	'	,
// '	19	'	,
// '	8	'	,
// '	33	'	,
// '	20	'	,
// '	38	'	,
// '	20	'	,
// '	34	'	,
// '	25	'	,
// '	9	'	,
// '	16	'	,
// '	2	'	,
// '	27	'	,
// '	23	'	,
// '	15	'	,
// '	16	'	,
// '	40	'	,
// '	3	'	,
// '	31	'	,
// '	3	'	); 

// $result = array_count_values($stuff);
// asort($result);
// end($result);
// $answer = key($result);

// echo $answer;


// $vals = array_count_values($stuff);
// echo 'No. of NON Duplicate Items: '.count($vals).'<br><br>';
// print_r($vals);

// $values = array_count_values($stuff);
// foreach ($values as $k => $val) {
// 	echo $k.' - '. $val.'</br>';
    // if (array_key_exists($val, $values) && $values[$val] >= 3) {
    //     echo 'Obsazeno <br>';
    // } else {
    //     echo $val . '<br>';
    // }
// }

?>

<!-- /.container-fluid -->
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="<?= site_url('public/js/leave.js'); ?>"></script>
