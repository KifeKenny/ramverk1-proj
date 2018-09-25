--
-- Create a database for local use
--
DROP DATABASE ramverk1Proj;
CREATE DATABASE IF NOT EXISTS ramverk1Proj;
USE ramverk1Proj;

--
-- Create a database user for the local use
--
GRANT ALL ON ramverk1Proj.* TO anax@localhost IDENTIFIED BY 'anax';
