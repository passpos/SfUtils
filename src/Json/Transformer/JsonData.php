<?php

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace SfUtils\Json\Transformer;

/**
 * Interconversion between JSON and Array.
 *
 * @author passpos <passpos@outlook.com>
 */
class JsonData {

    /**
     * Json to Array.
     * @param string $path Get json file path.
     * @return array|null
     */
    public function getArrayData($path): ?array {
        $jsonData = file_get_contents($path);
        $arrayData = json_decode($jsonData, true, 512);
        return $arrayData;
    }

    /**
     * Array to Json.
     * @param  array  $arrayData
     * @return string $jsonData
     */
    public function setJsonData(array $arrayData) {
        $encodedJson = json_encode($arrayData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $jsonData = mb_convert_encoding($encodedJson, "UTF-8");
        return $jsonData;
    }

}
