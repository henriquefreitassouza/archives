---
title: 'Setting up Metabase and PostgreSQL with Docker'
author: henriquesouza
publishDate: 2020-11-17 09:10:00
lastMod: 2021-11-20 09:10:00
summary: How to built a simple service architecture, easy to maintain and portable using Docker? Throughout this post, you'll discover how to do that integrating a PostgreSQL database with Metabase
description: 'Setting up Metabase and PostgreSQL with Docker'
image_description: 'Metabase, PostgreSQL and Docker logos'
categories:
- Automation
featured: true
---

Published on November 17, 2020 and updated on November 20, 2021.

## Isolating environments with Docker

A infrastructure that scale as demand increase is essential for any digital product with reach. The ability to scale depends on many things, from the technical specifications used by server machines to the chosen architecture. One of these variables, topic to be discussed in this post, is the configuration for the environment. A well planned environment is easy to maintain and change, helping to avoid -- or to reduce the impact -- of a maintenance, being it scheduled or not.

You'll probably already saw this problem: the same software is developed in one machine, stored in a repository on another machine, copied and modified on other five machines by developers, merged in the repository, moved to a staging server and then moved again to the production environment. There are many machines, many configurations and possibly the software that worked at some of these machines may not work on others. Hours from developers are spent trying to find the source of the error after the deploy, just to find out that it was a matter of changing the version used by the programming language or the database that is installed on the production machine. Problem solved, it is time to mirror the same configuration on all machines used for development. It happens that the software will now use a new dependency, which requires some new configuration in the environment in which it is hosted. If this configuration is missing at any single one of these machines used for development, the app won't work as expected, and more time from developers will be spent to correct the problem.

It is to solve problems like these that **Docker** exists, a container manager. A container is an isolated environment. Isolation is achieved by ensuring that, inside the environment, all the necessary tools that make the app work are available and use the correct versions. Docker use configuration files called **Dockerfiles**, which determine the set of configurations for each environment. These files are portable, they can be copied into different machines so the exact environment can be replicated in a new machine, disregarding the differences among machines.

Let's explore Docker, one example of a Dockerfile and find out how to manage more than one container, or environment.

## Docker installation

The first step is to install Docker on your computer. Docker can be downloaded on its {{< anchor href="https://www.docker.com/" target="_blank" >}}official website{{< /anchor >}}. Once Docker is installed, open a console and type the following command (if you're using Linux, you may need to use sudo to grant root level permissions to Docker):

{{< highlight bash >}}
docker --version
{{< /highlight >}}

If Docker is installed, you should see on the screen which version of Docker is installed. The next step is to install {{< anchor href="https://docs.docker.com/compose/install/" target="_blank" >}}Docker Compose{{< /anchor >}}, a Docker utility that ease managing multiple containers. Download and install Docker Compose on your computer. Next, open a terminal and type the following command:

{{< highlight bash >}}
docker-compose --version
{{< /highlight >}}

If Docker Compose is installed, you will see on the screen which version of Docker Compose is installed.

{{< image src="images/figure1-docker-and-docker-compose-installed.webp" alt="Docker and Docker Compose versions installed on my machine." caption="Docker and Docker Compose versions installed on my machine. Source: Author." title="Docker and Docker Compose versions installed on my machine." lazy="true" >}}

## Download the images
Now that Docker is installed on the machine, we can create the containers which we'll use in this tutorial: one with {{< anchor href="https://www.metabase.com/" target="_blank" >}}Metabase{{< /anchor >}} and another one with {{< anchor href="https://www.postgresql.org/" target="_blank" >}}PostgreSQL{{< /anchor >}}.

Beyond ensuring a controlled environment for hosting software, another great advantage of Docker is its portability. You can create and configure an environment and share with other people so they don't have to do the same work from scratch. This is so common among Docker community that there is even a repository with templates for environments ready to be used, called {{< anchor href="https://hub.docker.com/" target="_blank" >}}Docker Hub{{< /anchor >}}. These environment templates are called **images**. An image have all files and tools necessary for the environment to work in isolation. Images are like the plant of a house while the house is a container. It is based on the image that the container is created. There are official images for many popular apps including WordPress, MySQL or Node.js and other images that were created by people from Docker community.

We'll use two images: one from {{< anchor href="https://hub.docker.com/r/metabase/metabase" target="_blank" >}}Metabase{{< /anchor >}} and one from {{< anchor href="https://hub.docker.com/_/postgres" target="_blank" >}}PostgreSQL{{< /anchor >}}. It is necessary to download both images from Docker Hub. To download the PostgreSQL image, open a terminal and type the following command:

{{< highlight bash >}}
docker pull postgres
{{< /highlight >}}

You can check out the download progress using the terminal. Once this is finished, download the image from Metabase typing the following command:

{{< highlight bash >}}
docker pull metabase/metabase
{{< /highlight >}}

Each image available on Docker Hub have a version, and the latest version is identified by a tag called latest. It is this version that is downloaded by default when no tag is specified. You may need different versions for apps that need to run on tools with specific versions. {{< anchor href="https://www.mautic.org/" >}}Mautic{{< /anchor >}}, a marketing automation tool, is an example of such app, which by the time this post was published it don't work with PHP 7.3 or above, so the environment must have at most PHP 7.2. Each image on Docker Hub have a page with instructions on how to download each version of an image.

With all images ready to be used on your machine, it is time to configure the containers.

## Creating a container

To use the images it is necessary to inform Docker how they will be used. You can use each image as it was downloaded from the repository or modify it before creating the container. If using the image the way it was downloaded, Docker know what it needs to do and you can simply create a container. To create a container using the Metabase image, for instance, just run the following command:

{{< highlight bash >}}
docker run -p 3000:3000 metabase/metabase
{{< /highlight >}}

A new container is created with the command run and some arguments. The only required argument is the name of the image that will be used to generate a container. For Metabase to be accessible, it is necessary to map a port from your machine to a port from the container. This is done by using the flag "p". The first specified port is one from your machine and the second one is from the container, separated by colons (:). **Make sure port 3000 on your machine is free, otherwise use a door that is free**.

By default, the container running Metabase expose port 3000. Open a browser and type localhost:3000. You should see a screen to setup Metabase. Since we'll use Metabase along with PostgreSQL, shutdown the connection between the terminal and the container by accessing the terminal and making a forced stop with shortcut CTRL + C. This stop just closed the connection between the terminal and the container, but the container is still running. It needs to be stopped so the port 3000 gets released. To do that, we'll list all containers that are running with the command:

{{< highlight bash >}}
docker ps
{{< /highlight >}}

See in the terminal that the last column is called name. This column identifies each container created, and these names are automatically generated if not specified. Each time you create a new container, Docker will give a random name for that container. You can specify the name using the flag "name". For now, shutdown the container with the command:

{{< highlight bash >}}
docker stop container_name
{{< /highlight >}}

Where container_name is the name Docker gave to the newly created container, which is different from the name of the image.

## Creating a Dockerfile

You can modify an image downloaded from a repository or create an image from scratch. For that, you'll need to create a file called **Dockerfile** and configure it. Once the file is configured, you must inform Docker how to find this file and execute all commands that will create a new image.

To create a new image, create a folder in any directory from your computer and, right after, open a notepad. With the notepad opened, type the following lines:

{{< highlight dockerfile >}}
FROM metabase/metabase:latest
LABEL Description="This is a custom build based on the official Metabase image."
{{< /highlight >}}

Save the file in the directory created with the name Dockerfile. This Dockerfile have only two instructions:

- Use the most recent version of the base image from Metabase (if the image hadn't been downloaded, Docker would have tried to download the image from the repository);
- Describe the environment.

There are many commands that can be used in a Dockerfile, useful to do things like add other dependencies to an environment. The complete list of commands can be found at {{< anchor href="https://docs.docker.com/engine/reference/builder/" target="_blank" >}}the official Docker documentation{{< /anchor >}}.

Open a terminal and type the following commands, remembering to alter the code so that the directory is the one in your machine where there's a Dockerfile:

{{< highlight bash >}}
cd /path/to/Dockerfile
docker build --tag latest metabase_sandbox .
{{< /highlight >}}

Inspecting this code:

- Command cd is used to browse the structure of files and folders. The path to be typed should be the one where there's a newly created Dockerfile;
- Command build create a new image based on the image specified in the Dockerfile. The flag "tag" specify that a tag called latest should be added to the image, the name of the image will be metabase_sandbox and the path to the Dockerfile is the current directory (note the period after the name of the image, separated by an empty space. If the Dockerfile was in another directory the period would need to be replaced with the path to the Dockerfile).

You can check out each step on the creating of the image in your terminal. At the end, run the following command on the terminal:

{{< highlight bash >}}
docker image ls
{{< /highlight >}}

All images that you have on your computer will be shown on the terminal, including the newly created one, called metabase_sandbox. Test this new image running the command:

{{< highlight bash >}}
docker run -p 3000:3000 metabase_sandbox
{{< /highlight >}}

The result should be the same as when you created a container directly from the original image. Open a browser and type localhost:3000. The same Metabase configuration screen will appear.

Close the connection between the terminal and the container using CTRL + C. All images and containers created use physical space on your computer and you can save space by deleting everything that won't be used anymore. To do the cleaning, start by typing the following command:

{{< highlight bash >}}
docker ps -a
{{< /highlight >}}

Command ps will show all containers that were created, and flag "a" will also show all containers that aren't running. To delete the newly created container run the command:

{{< highlight bash >}}
docker rm container_name
{{< /highlight >}}

Where container_name is the name that Docker automatically gave after its creation or the name you gave by specifying the flag "name" when using the command run. The container will be deleted from your system. You can make the process of deleting a container automatic by appending the flag "rm" to run. This way, the container will be automatically deleted once it is shutdown.

Delete also the image metabase_sandbox. For that, with all containers that make use of this image stopped, run the following command:

{{< highlight bash >}}
docker image rm metabase_sandbox
{{< /highlight >}}

You can check that the image doesn't exist anymore by running the command:

{{< highlight bash >}}
docker image ls
{{< /highlight >}}

A Dockerfile is necessary to customize an existing image or creating one from scratch, but what when we need more than one service and these services have dependencies among themselves?

## Multiple containers in Docker with Docker Compose

There are tools designed specifically to work with multiple Docker containers. We'll use one tool that does that to centralize all environment configurations in a single place, and this tool is **Docker Compose**. Docker Compose uses a single file to configure all containers, and each container can have its own Dockerfile if necessary. This file used by Docker Container is called **docker-compose.yml** and it is written using {{< anchor href="https://en.wikipedia.org/wiki/YAML" target="_blank" >}}yaml{{< /anchor >}}. We'll create this file in the same directory in which the Dockerfile was created prior. Access this directory and create a new text file using this code:

{{< highlight yaml >}}
version: "3.8"

services:
	db:
    		image: postgres
    		container_name: postgresql_metabase
    		restart: always
    		environment:
        		POSTGRES_DB: metabase
        		POSTGRES_USER: metabase
        		POSTGRES_PASSWORD: db_password
    		volumes:
        		- db_data:/var/lib/postgresql/data
    		ports:
      	  	- 5432:5432

	dataviz:
    		image: metabase/metabase
    		container_name: metabase
    		restart: always
    		environment:
     	   	MB_DB_TYPE: postgres
       	 	MB_DB_DBNAME: metabase
       	 	MB_DB_PORT: 5432
        		MB_DB_USER: metabase
        		MB_DB_PASS: db_password
       	 	MB_DB_HOST: db
       	 	MB_DB_FILE: /metabase-data/metabase.db
    		depends_on:
      	  	- db
    		volumes:
       	 	- dataviz_data:/metabase-data
    		ports:
       	 	- 3000:3000

volumes:
	db_data:
	dataviz_data:
{{< /highlight >}}

There are many configurations in this file. This could all be done in separate Dockerfiles, except establishing a relationship among both containers. What this file is doing is:

- Specify which language version will be used in this file is 3.8. All docker-compose.yml files must specify at their first lines which version that they use. The most recent by the time this post was published is 3.8;
- Create two services: one called db and another one called dataviz. Services in this context are containers and their respective configurations;
- Create two **volumes**, repositories that store data created inside containers. Every time that a container is shutdown, all data is lost and volumes prevent this from happening. These volumes were just declared. Upon defining each service, the volumes will be used to map directories on both the local machine and the container, so files created are shared between the container and the machine. Docker have a default directory to store volumes, but you can use any other directory in your computer. It is important to note that volumes with declared directories will assume that this directory exist on every machine in which docker-compose.yml is installed, if don't an error will occur when creating the containers.

Each service have several configurations. The service db:

- Use the image Postgres. Since there's no version specified, the lastest one is assumed, The container is named postgresql_metabase and is configured to be destroyed every time the container is shutdown;
- Three environment variables are defined. One of many options when creating images is to declare environment variables, which can be modified. The Postgres image have many variables, and three of them are used when creating the container: POSTGRES_DB, POSTGRES_USER and POSTGRES_PASSWORD. These variables will be used to create a default database, user and password respectively. These access credentials will be used on Metabase later on to establish the connection with the database;
- Volume db_data is synchronized with the directory that store databases in PostgreSQL;
- Port 5432 is exposed on both the machine and the container to access the database.

And the service dataviz:

- Use the Metabase image previously downloaded;
- Specify that the container will be named metabase;
- Inform that the container should be removed once it is shutdown;
- Declare several environment variables that are used within this image of Metabase. These variables inform Metabase where the database is, which access credentials should it use and where, inside the container, will be stored the data file created by Metabase, at the variable MB_DB_FILE;
- Specify that the container depends on the service db. Docker should initialize first the container postgresql_metabase before initializing metabase;
- Specify a volume to store the data files created by Metabase;
- Expose port 3000 on both the machine and container.

Save the file with name docker-compose.yml. Note that we didn't used the Dockerfile previously created, but it is possible to specify its address inside docker-compose.yml if it is necessary to customize the image. We'll use the default images, setting up only the environment variables from each container, volumes to specify where to save data that can't be lost upon shutting down the container and the order of initialization.

Open a terminal and, in the directory in which there's a docker-compose.yml, type the following command:

{{< highlight bash >}}
docker-compose up
{{< /highlight >}}

Once the command is executed, both containers initialized. Browse to localhost:3000 and start the process of configuring Metabase. After setting up the database, select the option others and type the same data that were used to fill the environment variables for both Metabase and PostgreSQL. In the host field just type the name of the service created at docker-compose.yml, named db. Finish the configuration and, at the home screen of Metabase, you should see a database with some tables created next to the default database.

{{< image src="images/figure2-metabase-home-page.webp" alt="Database Metabase, created on PostgreSQL, connected to Metabase." caption="Database Metabase, created on PostgreSQL, connected to Metabase. Source: Author." title="Database Metabase, created on PostgreSQL, connected to Metabase." lazy="true" >}}

## Considerations

This is a simple architecture with two containers, but one architecture can have dozens or hundreds of services that are connected with one another to make a product work, as the need of each company. Even this architecture could have been done differently. I recommend reading the documentation of {{< anchor href="https://docs.docker.com/" target="_blank" >}}Docker{{< /anchor >}} and {{< anchor href="https://docs.docker.com/compose/" target="_blank" >}}Docker Compose{{< /anchor >}} to explore all possibilities when configuring containers.

Infrastructures with many machines and apps on distributed environments use tools such as {{< anchor href="https://kubernetes.io/" target="_blank" >}}Kubernetes{{< /anchor >}}, designed for such scenario.

Let's configure environments!
