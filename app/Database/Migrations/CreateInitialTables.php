<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialTables extends Migration
{
    public function up()
    {
        // Users Table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 100],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'ENUM', 'constraint' => ['superadmin', 'bupati'], 'default' => 'bupati'],
            'region_key' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // Regions Table
        $this->forge->addField([
            'region_key' => ['type' => 'VARCHAR', 'constraint' => 100],
            'code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'province_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'region_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'region_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'display_name' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('region_key', true);
        $this->forge->createTable('regions');

        // Provinces Table
        $this->forge->addField([
            'province_key' => ['type' => 'VARCHAR', 'constraint' => 100],
            'code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'province_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'display_name' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('province_key', true);
        $this->forge->createTable('provinces');

        // Packages Table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'source_id' => ['type' => 'VARCHAR', 'constraint' => 100],
            'package_name' => ['type' => 'TEXT'],
            'owner_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'owner_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'satker' => ['type' => 'VARCHAR', 'constraint' => 255],
            'location_raw' => ['type' => 'TEXT', 'null' => true],
            'budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'funding_source' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'procurement_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'procurement_method' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'selection_date' => ['type' => 'DATE', 'null' => true],
            'schema_version' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'severity' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'reason' => ['type' => 'TEXT', 'null' => true],
            'is_mencurigakan' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true],
            'is_pemborosan' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => true],
            'is_priority' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_flagged' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'risk_score' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'active_tag_count' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'mapped_region_count' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('packages');

        // Region Metrics Table
        $this->forge->addField([
            'region_key' => ['type' => 'VARCHAR', 'constraint' => 100],
            'total_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_flagged_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'total_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'avg_risk_score' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'max_risk_score' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'central_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'provincial_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'local_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'other_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'central_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'provincial_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'local_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'other_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'central_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'provincial_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'local_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'other_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'central_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'provincial_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'local_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'other_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'med_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'high_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'absurd_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('region_key', true);
        $this->forge->createTable('region_metrics');

        // Province Metrics Table
        $this->forge->addField([
            'province_key' => ['type' => 'VARCHAR', 'constraint' => 100],
            'total_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_flagged_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'total_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'avg_risk_score' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'max_risk_score' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'med_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'high_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'absurd_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('province_key', true);
        $this->forge->createTable('province_metrics');

        // Owner Metrics Table
        $this->forge->addField([
            'owner_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'owner_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'total_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_flagged_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'total_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'med_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'high_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'absurd_severity_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey(['owner_type', 'owner_name'], true);
        $this->forge->createTable('owner_metrics');

        // Package Regions Table (Join)
        $this->forge->addField([
            'package_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'region_key' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey(['package_id', 'region_key'], true);
        $this->forge->createTable('package_regions');

        // Package Provinces Table (Join)
        $this->forge->addField([
            'package_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'province_key' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey(['package_id', 'province_key'], true);
        $this->forge->createTable('package_provinces');

        // National Summary Table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 1, 'default' => 1],
            'total_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_priority_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_potential_waste' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'total_budget' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'default' => 0.00],
            'unmapped_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'multi_location_packages' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('national_summary');

        // Assets Table
        $this->forge->addField([
            'key' => ['type' => 'VARCHAR', 'constraint' => 100],
            'value' => ['type' => 'LONGTEXT'],
        ]);
        $this->forge->addKey('key', true);
        $this->forge->createTable('assets');
    }

    public function down()
    {
        $this->forge->dropTable('users');
        $this->forge->dropTable('regions');
        $this->forge->dropTable('provinces');
        $this->forge->dropTable('packages');
        $this->forge->dropTable('region_metrics');
        $this->forge->dropTable('province_metrics');
        $this->forge->dropTable('owner_metrics');
        $this->forge->dropTable('package_regions');
        $this->forge->dropTable('package_provinces');
        $this->forge->dropTable('national_summary');
        $this->forge->dropTable('assets');
    }
}
