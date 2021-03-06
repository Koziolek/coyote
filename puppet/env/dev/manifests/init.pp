# create a new run stage to ensure certain modules are included first
stage { 'pre':
	before => Stage['main']
}

# add the baseconfig module to the new 'pre' run stage
class { 'baseconfig':
	stage => 'pre'
}

# set defaults for file ownership/permissions
File {
	owner => 'root',
	group => 'root',
	mode  => '0644',
}

# set default path for Exec calls
Exec {
	path => [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/' ]
}

include baseconfig, nginx, php, postgresql, mongodb, composer, redis, elasticsearch, supervisor