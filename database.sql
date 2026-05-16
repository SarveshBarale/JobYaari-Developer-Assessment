-- Jobyaari Blog Management System - Database Setup
-- Import this file via phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS jobyaari_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE jobyaari_db;

-- Admins table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blogs table
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    short_description TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    category ENUM('Admit Card','Result','Latest Jobs','Answer Key') NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin: admin / admin123
INSERT INTO admins (username, password) VALUES
('admin', '$2y$10$65oqq.9zd1DidBwGPPjnQulF7jgpceLc/WZi1jbAuDe3c4Am05LFK');

-- Sample blogs
INSERT INTO blogs (title, short_description, content, category, image, created_at) VALUES
(
    'SSC CGL 2024 Admit Card Released',
    'Staff Selection Commission has released the admit card for SSC CGL 2024 Tier-1 examination. Candidates can download their hall ticket from the official website.',
    '<p>The Staff Selection Commission (SSC) has officially released the <strong>SSC CGL 2024 Tier-1 Admit Card</strong>. All registered candidates can now download their hall tickets from the official SSC website.</p><h5>How to Download Admit Card</h5><ol><li>Visit the official SSC website at ssc.nic.in</li><li>Click on the Admit Card link on the homepage</li><li>Enter your Registration Number and Date of Birth</li><li>Click Submit and download your Admit Card</li><li>Take a printout for exam day</li></ol><h5>Important Details</h5><ul><li>Exam Date: 15th to 25th July 2024</li><li>Exam Mode: Computer Based Test (CBT)</li><li>Reporting Time: 1 hour before exam</li></ul><p>Candidates must carry a valid photo ID along with the admit card on the day of examination.</p>',
    'Admit Card',
    NULL,
    '2024-06-01 10:00:00'
),
(
    'UPSC Civil Services Result 2024 Declared',
    'Union Public Service Commission has declared the final result of Civil Services Examination 2024. Check your result on the official UPSC website now.',
    '<p>The <strong>Union Public Service Commission (UPSC)</strong> has declared the final result of the Civil Services Examination 2024. Candidates who appeared in the Personality Test (Interview) can now check their results.</p><h5>Result Statistics</h5><ul><li>Total Vacancies: 1056</li><li>Total Candidates Recommended: 1056</li><li>Female Candidates: 384</li><li>Male Candidates: 672</li></ul><h5>How to Check Result</h5><ol><li>Go to upsc.gov.in</li><li>Click on "Written Results" section</li><li>Find Civil Services Examination 2024 Final Result</li><li>Download the PDF and search your Roll Number</li></ol><p>Selected candidates will receive appointment letters from the Department of Personnel and Training (DoPT) shortly.</p>',
    'Result',
    NULL,
    '2024-06-05 12:00:00'
),
(
    'Railway RRB NTPC 2024 Recruitment - 11558 Vacancies',
    'Railway Recruitment Board has announced RRB NTPC 2024 recruitment for 11558 posts. Online applications are open. Check eligibility and apply now.',
    '<p>The <strong>Railway Recruitment Board (RRB)</strong> has released the official notification for <strong>RRB NTPC 2024</strong> recruitment. A total of <strong>11,558 vacancies</strong> are available across various posts.</p><h5>Post Details</h5><ul><li>Junior Clerk cum Typist: 990 posts</li><li>Accounts Clerk cum Typist: 361 posts</li><li>Junior Time Keeper: 20 posts</li><li>Trains Clerk: 592 posts</li><li>Commercial cum Ticket Clerk: 2022 posts</li><li>Station Master: 994 posts</li><li>Goods Guard: 3144 posts</li><li>Senior Commercial cum Ticket Clerk: 1736 posts</li></ul><h5>Eligibility</h5><ul><li>Age: 18-33 years (relaxation as per rules)</li><li>Education: Graduation from recognized university</li></ul><h5>Important Dates</h5><ul><li>Application Start: 14 September 2024</li><li>Last Date: 13 October 2024</li><li>Exam Date: To be announced</li></ul>',
    'Latest Jobs',
    NULL,
    '2024-06-10 09:00:00'
),
(
    'SSC CHSL 2024 Answer Key Released',
    'SSC has released the provisional answer key for CHSL 2024 Tier-1 examination. Candidates can raise objections against the answer key till the last date.',
    '<p>The <strong>Staff Selection Commission (SSC)</strong> has released the <strong>Provisional Answer Key</strong> for the CHSL 2024 Tier-1 examination. Candidates who appeared in the exam can now check and challenge the answer key.</p><h5>How to Check Answer Key</h5><ol><li>Visit ssc.nic.in</li><li>Login with your credentials</li><li>Click on "CHSL 2024 Answer Key" link</li><li>Download and verify your answers</li></ol><h5>How to Raise Objection</h5><ul><li>Objection Fee: Rs. 100 per question</li><li>Last Date for Objection: 5 days from release</li><li>Mode: Online only</li></ul><p>The final answer key will be released after reviewing all valid objections. The result will be prepared based on the final answer key.</p>',
    'Answer Key',
    NULL,
    '2024-06-15 11:00:00'
),
(
    'IBPS PO 2024 Admit Card - Download Now',
    'IBPS has released the admit card for PO Prelims 2024. The examination is scheduled for October 2024. Download your call letter from ibps.in.',
    '<p><strong>Institute of Banking Personnel Selection (IBPS)</strong> has released the <strong>IBPS PO Prelims 2024 Admit Card</strong>. Candidates can download their call letters from the official IBPS website.</p><h5>Exam Schedule</h5><ul><li>Exam Date: 19, 20 October 2024</li><li>Exam Mode: Online (CBT)</li><li>Duration: 1 Hour</li></ul><h5>Download Steps</h5><ol><li>Visit ibps.in</li><li>Click on CRP PO/MT Admit Card link</li><li>Enter Registration Number and Password/DOB</li><li>Download and print the admit card</li></ol><h5>Documents Required at Exam Center</h5><ul><li>Printed Admit Card</li><li>Original Photo ID Proof</li><li>Passport size photograph</li></ul>',
    'Admit Card',
    NULL,
    '2024-06-20 08:00:00'
),
(
    'NEET UG 2024 Result Announced',
    'National Testing Agency has declared NEET UG 2024 result. Over 24 lakh students appeared for the exam. Check your scorecard on neet.nta.nic.in.',
    '<p>The <strong>National Testing Agency (NTA)</strong> has officially declared the <strong>NEET UG 2024 Result</strong>. More than 24 lakh candidates appeared for the examination held on 5th May 2024.</p><h5>Result Highlights</h5><ul><li>Total Registered: 24,06,079</li><li>Total Appeared: 23,33,297</li><li>Total Qualified: 13,16,268</li><li>Qualifying Percentage: 56.4%</li></ul><h5>How to Check Result</h5><ol><li>Visit neet.nta.nic.in</li><li>Click on NEET UG 2024 Result link</li><li>Enter Application Number and Date of Birth</li><li>View and download your scorecard</li></ol><p>Counselling for MBBS/BDS admissions will be conducted by MCC (Medical Counselling Committee) based on NEET UG 2024 scores.</p>',
    'Result',
    NULL,
    '2024-06-25 14:00:00'
);
