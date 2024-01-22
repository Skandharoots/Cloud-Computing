<?php

namespace Tests\Unit\API\LogController;

use Illuminate\Http\Response;
use Tests\AssertableJson;
use Tests\Unit\API\APIUnitTestCase;
use Tests\Validators\LinksValidator;
use Tests\Validators\MetaValidator;

class LogControllerIndexTest extends APIUnitTestCase
{
    public function test_logs_index_returns_paginated_data()
    {
        $this->get('/api/logs?filter[user_uuid]=' . $this->get_random_user()->uuid)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $data) {
                    $data->each(function (AssertableJson $log) {
                        LogResourceValidator::validate($log);
                    });
                })
                ->has('links', function (AssertableJson $links) {
                    LinksValidator::validate($links);
                })
                ->has('meta', function (AssertableJson $meta) {
                    MetaValidator::validate($meta);
                });
            });
    }

    public function test_logs_index_returns_not_paginated_data()
    {
        $this->get('/api/logs?filter[user_uuid]=' . $this->get_random_user()->uuid . '&paginate=false')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $data) {
                    $data->each(function (AssertableJson $log) {
                        LogResourceValidator::validate($log);
                    });
                });
            });
    }

    public function test_logs_index_returns_correct_amount_of_items_with_custom_per_page_and_page()
    {
        $response = $this->get('/api/logs?filter[user_uuid]=' . $this->get_random_user()->uuid . '&per_page=2&page=2')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $data) {
                    $data->each(function (AssertableJson $log) {
                        LogResourceValidator::validate($log);
                    });
                })
                ->has('links', function (AssertableJson $links) {
                    LinksValidator::validate($links);
                })
                ->has('meta', function (AssertableJson $meta) {
                    MetaValidator::validate($meta);
                });
            });

        $this->assertEquals(2, $response->json('meta.current_page'));
    }

    public function test_logs_filter_by_type()
    {
        $type = $this->get_random_log_type();

        $response = $this->get('/api/logs?filter[user_uuid]=' . $this->get_random_user()->uuid . '&filter[type]=' . $type)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data')
                    ->has('data', function (AssertableJson $data) {
                        $data->eachNullable(function (AssertableJson $log) {
                            LogResourceValidator::validate($log);
                        });
                    })
                    ->has('links', function (AssertableJson $links) {
                        LinksValidator::validate($links);
                    })
                    ->has('meta', function (AssertableJson $meta) {
                        MetaValidator::validate($meta);
                    });
            });

        $logs = $response->json('data');

        if (count($logs) > 0) {
            foreach ($logs as $log) {
                $this->assertEquals($type, $log['type']);
            }
        }
    }

    public function test_logs_index_returns_400_when_filter_user_uuid_is_missing()
    {
        $this->get('/api/logs')
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'message' => 'Missing filter[user_uuid], it is required.',
            ]);
    }
}
